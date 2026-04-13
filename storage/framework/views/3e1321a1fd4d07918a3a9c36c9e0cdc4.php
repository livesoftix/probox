

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box">
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Hyper</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Tables</a>
            </li>
            <li class="breadcrumb-item active">Data Tables</li>
        </ol>
    </div>
    <h4 class="page-title">Job Sheet</h4>
</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="card mt-2">
<div class="card-body">
    <div class="tab-content">
        <div class="col-12">
            <form action="<?php echo e(route('job.report')); ?>" method="GET" class="form-inline" id="search-form">
                <div class="row">
                    <!-- Start Date -->
                    <div class="form-group col-xl-2">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="<?php echo e(request()->get('start_date')); ?>">
                    </div>

                    <!-- End Date -->
                    <div class="form-group col-xl-2">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="<?php echo e(request()->get('end_date')); ?>">
                    </div>

                    <!-- JS No -->
                    <div class="form-group col-xl-2">
                        <label for="v_no" class="form-label">JS No</label>
                        <select name="v_no" class="form-control select2" data-toggle="select2"
                            data-placeholder="Select JS No">
                            <option value="">Select JS No</option>
                            <?php $__currentLoopData = $vehicleNumbers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $number): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($number); ?>"
                                    <?php echo e(request()->get('v_no') == $number ? 'selected' : ''); ?>>
                                    <?php echo e($number); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Customer Dropdown -->
                    <div class="form-group col-xl-2">
                        <label for="aid" class="form-label">Customer</label>
                        <select name="aid" class="form-control select2" data-toggle="select2"
                            data-placeholder="Select Customer">
                            <option value="">All Customers</option>
                            <?php $__currentLoopData = $uniqueCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>"
                                    <?php echo e(request()->get('aid') == $id ? 'selected' : ''); ?>>
                                    <?php echo e($title); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Item Dropdown -->
                    <div class="form-group col-xl-2">
                        <label for="product_id" class="form-label">Item</label>
                        <select name="product_id" class="form-control select2" data-toggle="select2"
                            data-placeholder="Select Item">
                            <option value="">All Items</option>
                            <?php $__currentLoopData = $uniqueItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>"
                                    <?php echo e(request()->get('product_id') == $id ? 'selected' : ''); ?>>
                                    <?php echo e($name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="<?php echo e(route('job.index')); ?>">
                            <button type="button" class="btn btn-success"
                                onclick="return checkPermission()">Add Item</button>
                        </a>
                        <a href="<?php echo e(route('job.report')); ?>" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show"
                        role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                        <strong>Success - </strong> <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <div class="col-12">
<div class="card mt-2">
<div class="card-body">
<button type="button" class="btn btn-secondary" onclick="printUserTable()">
    User Print
</button>
<button type="button" class="btn btn-secondary" onclick="printAdminTable()">
    Admin Print
</button>
<div class="tab-content">
    <div class="tab-pane show active" id="basic-datatable-preview">
        <div style="overflow-x: auto;">
            <table id="basic-datatable"
                class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>JS No</th>
                        <th>Product Name</th>
                        <th>Prepared By</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>JS Date</th>
                        <th>Delivery Date</th>
                        <th class="no-print">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>JS-<?php echo e($detail['v_no']); ?></td>
                            <td><?php echo e($detail['product_name'] ?? 'N/A'); ?></td>
                            <td><?php echo e($detail['prepared_by']); ?></td>
                            <td><?php echo e($detail['account_title']); ?></td>
                            <td><?php echo e($detail['job_status']); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($detail['created_at'])->format('d-m-Y')); ?>

                            </td>
                            <td><?php echo e($detail['delivery_date'] ? \Carbon\Carbon::parse($detail['delivery_date'])->format('d-m-Y') : 'N/A'); ?>

                            </td>
<td class="no-print">
    <div class="d-flex">
        <a href="<?php echo e(route('job-details.edit', $detail['v_no'])); ?>"
            onclick="return checkPermissionEdit()">
            <button type="button"
                class="btn btn-primary">
                Edit
            </button>
        </a>
        <form
            action="<?php echo e(route('job-details.destroy')); ?>"
            method="POST"
            onsubmit="return confirm('Are you sure you want to delete V No <?php echo e($detail['v_no']); ?>?');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <input type="hidden" name="v_no"
                value="<?php echo e($detail['v_no']); ?>">
            <button type="submit"
                class="btn btn-danger"
                onclick="return checkPermissionDel()">Delete</button>
        </form>
    </div>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
</div>





        <div id="print-section" style="display: none;">
            <div id="print-datatable">
                <div style="text-align: Center;">
                    <h3>
                        <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                <?php echo e($detail['job_type']); ?>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        Job Sheet
                        <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                <?php echo e($detail['job_status']); ?>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </h3>
                </div>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
                    <tr>
                        <td style="width: 60%; vertical-align: top;">
                            <h4>Date: <span style="font-weight: normal;">
                                    <?php echo e(\Carbon\Carbon::today()->format('d-m-Y')); ?>

                                </span></h4>
                            <h4>Prepared By:
                                <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                        <span style="font-weight: normal;">
                                            <?php echo e($detail['prepared_by']); ?></span>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </h4>
                            <h4>Customer:
                                <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                        <span style="font-weight: normal;">
                                            <?php echo e($detail['account_title']); ?> </span>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </h4>
                            <h4>Job Sheet No:
                                <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                        <span style="font-weight: normal;">
                                            <?php echo e($detail['v_no']); ?></span>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </h4>
                        </td>
                        
                    </tr>
                </table>

                <!-- New section with JS Date and Delivery Date in a 2-column table -->
                <div class="mt-3">

                    <table
                        style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;">
                        <tr>
                            <td
                                style="width: 60%; vertical-align: top; padding: 10px; line-height: 1.6;">
                                
                                <?php $poShown = false; ?>
                                <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $filteredBatches = array_filter(
                                            $detail['batch_info'],
                                            function ($batch) {
                                                return $batch[
                                                    'batch_no'
                                                ] !== 'N/A' &&
                                                    $batch['batch_qty'] !==
                                                        'N/A' &&
                                                    (auth()->user()
                                                        ->is_admin == 1 ||
                                                        $batch[
                                                            'job_status'
                                                        ] == 'Pending');
                                            },
                                        );
                                    ?>
                                    <?php if(count($filteredBatches) > 0 && !$poShown): ?>
                                        <h3>PO Details</h3>
                                        <?php $__currentLoopData = $filteredBatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <p><strong>PO:</strong>
                                                <?php echo e($batch['batch_no']); ?> &nbsp;
                                                <strong>Qty:</strong>
                                                <?php echo e($batch['batch_qty']); ?></p>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php $poShown = true; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <h3>Product Detail</h3>
                                <p><strong>Product Name:</strong>
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            <?php echo e($detail['product_name'] ?? 'N/A'); ?>,
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>

                                <p><strong>Item Type:</strong>
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            <?php echo e($detail['item_code'] ?? 'N/A'); ?>,
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>

                                <p><strong>Packet Size:</strong>
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            L:
                                            <?php echo e($detail['product_length'] ?? 'N/A'); ?>,
                                            W:
                                            <?php echo e($detail['product_width'] ?? 'N/A'); ?>,
                                            G:
                                            <?php echo e($detail['product_grammage'] ?? 'N/A'); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>

                                <?php
                                    $assignedEmployees = [];
                                    foreach (
                                        $groupedJobDetails
                                        as $detail
                                    ) {
                                        if (
                                            auth()->user()->is_admin == 1 ||
                                            $detail['job_status'] ==
                                                'Pending'
                                        ) {
                                            foreach (
                                                $detail['employees'] ?? []
                                                as $emp
                                            ) {
                                                if (
                                                    $emp !== 'N/A' &&
                                                    !empty($emp)
                                                ) {
                                                    $assignedEmployees[] = $emp;
                                                }
                                            }
                                        }
                                    }
                                ?>
                                <?php if(count($assignedEmployees) > 0): ?>
                                    <p><strong>Assigned To:</strong>
                                        <?php echo e(implode(', ', $assignedEmployees)); ?>

                                    </p>
                                <?php endif; ?>

                                
                                <?php
                                    $showBox = false;
                                    foreach (
                                        $groupedJobDetails
                                        as $detail
                                    ) {
                                        if (
                                            (auth()->user()->is_admin ==
                                                1 ||
                                                $detail['job_status'] ==
                                                    'Pending') &&
                                            in_array(
                                                'Boxboard Cutting',
                                                $detail['departments'] ??
                                                    [],
                                            )
                                        ) {
                                            $showBox = true;
                                            break;
                                        }
                                    }
                                ?>

                                <?php if($showBox): ?>
                                    <h4>Boxboard Cutting</h4>
                                    <p>
                                        <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                                <strong>Process:</strong>
                                                <?php
                                                    $proc = $detail['department_Process'] ?? 'N/A';
                                                    if (is_string($proc) && str_starts_with($proc, '[')) {
                                                        $decoded = json_decode($proc, true);
                                                        if (is_array($decoded)) {
                                                            echo implode(', ', array_filter($decoded, fn($v) => $v !== null && $v !== ''));
                                                        } else {
                                                            echo $proc;
                                                        }
                                                    } else {
                                                        echo $proc;
                                                    }
                                                ?>,
                                                <strong>Length:</strong>
                                                <?php
                                                    $l = $detail['length'] ?? 'N/A';
                                                    if (is_string($l) && str_starts_with($l, '[')) {
                                                        $decoded = json_decode($l, true);
                                                        if (is_array($decoded)) {
                                                            echo implode(', ', array_filter($decoded, fn($v) => $v !== null && $v !== ''));
                                                        } else {
                                                            echo $l;
                                                        }
                                                    } else {
                                                        echo $l;
                                                    }
                                                ?>,
                                                <strong>Width:</strong>
                                                <?php
                                                    $w = $detail['width'] ?? 'N/A';
                                                    if (is_string($w) && str_starts_with($w, '[')) {
                                                        $decoded = json_decode($w, true);
                                                        if (is_array($decoded)) {
                                                            echo implode(', ', array_filter($decoded, fn($v) => $v !== null && $v !== ''));
                                                        } else {
                                                            echo $w;
                                                        }
                                                    } else {
                                                        echo $w;
                                                    }
                                                ?>,
                                                <strong>No. of Cuts:</strong>
                                                <?php
                                                    $cuts = $detail['no_of_cut'] ?? 'N/A';
                                                    if (is_string($cuts) && str_starts_with($cuts, '[')) {
                                                        $decoded = json_decode($cuts, true);
                                                        if (is_array($decoded)) {
                                                            echo implode(', ', array_filter($decoded, fn($v) => $v !== null && $v !== ''));
                                                        } else {
                                                            echo $cuts;
                                                        }
                                                    } else {
                                                        echo $cuts;
                                                    }
                                                ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                <?php endif; ?>

                                <p><strong>No. of Colors:</strong>
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            <?php echo e($detail['product_color'] ?? 'N/A'); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>

                                <p><strong>Lamination Size:</strong>
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            <?php echo e($detail['product_lam_size'] ?? 'N/A'); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>

                                <p><strong>Corrugation Size:</strong>
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            <?php echo e($detail['product_curr_size'] ?? 'N/A'); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>

                                <p><strong>UV Type:</strong>
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            <?php echo e($detail['product_simple'] == 1 ? 'Simple' : ''); ?>

                                            <?php echo e($detail['product_spot'] == 1 ? 'Spot' : ''); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>

                                <p><strong>No of Ups:</strong>
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            <?php echo e($detail['product_ups'] ?? 'N/A'); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>

                                <p><strong>Country:</strong>
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            <?php echo e($detail['product_country'] ?? 'N/A'); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>

                                <p><strong>Description:</strong>
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            <?php echo e($detail['product_description'] ?? 'N/A'); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>
                            </td>

                            
                            <td
                                style="width: 40%; vertical-align: top; text-align: center; padding: 10px;">
                                <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                        <?php if($detail['product_img'] != 'N/A'): ?>
                                            <img src="<?php echo e(asset('storage/' . $detail['product_img'])); ?>"
                                                alt="Product Image"
                                                style="max-width: 100%; max-height: 250px; border: 1px solid #ccc; padding: 5px;">
                                        <?php else: ?>
                                            <p>No Image Available</p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                        </tr>
                    </table>

                </div>



                <div style="margin-top: 10px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="text-align: left;  padding: 5px;">

                                <h3>Job Detail</h3>

                                <h4>Packets to be Used from Stock</h4>
                                <h4>
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vNo => $jobDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $jobDetail['job_status'] == 'Pending'): ?>
                                            <?php for($i = 0; $i < count($jobDetail['box_item']); $i++): ?>
                                                Name:
                                                <span
                                                    style="font-weight: normal;">
                                                    <?php echo e($jobDetail['box_item'][$i] ?? 'N/A'); ?>

                                                    { L:
                                                    <?php echo e($jobDetail['box_length'][$i] ?? 'N/A'); ?>

                                                    x W:
                                                    <?php echo e($jobDetail['box_width'][$i] ?? 'N/A'); ?>

                                                    }
                                                </span>
                                                Qty:
                                                <span
                                                    style="font-weight: normal;">
                                                    <?php echo e($jobDetail['box_qty'][$i] ?? 'N/A'); ?>

                                                </span>
                                                <br>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </h4>

                                <h4>No.of Packets to be Used:
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            <span style="font-weight: normal;">
                                                <?php echo e($detail['packets'] ?? 'N/A'); ?>

                                            </span>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </h4>





                                <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $filteredBatches = array_filter(
                                            $detail['batch_info'],
                                            function ($batch) {
                                                return $batch[
                                                    'batch_no'
                                                ] !== 'N/A' &&
                                                    $batch['batch_qty'] !==
                                                        'N/A' &&
                                                    (auth()->user()
                                                        ->is_admin == 1 ||
                                                        $batch[
                                                            'job_status'
                                                        ] == 'Pending');
                                            },
                                        );
                                    ?>

                                    <?php if(isset($detail['job_type']) && $detail['job_type'] == 'Pharmaceutical'): ?>
                                        <h3 class="mt-3">Batch Details</h3>
                                        <?php $totalQty = 0; ?>
                                        <?php $__currentLoopData = $filteredBatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <h4>Batch: <span
                                                    style="font-weight: normal;">
                                                    <?php echo e($batch['batch_no']); ?></span>
                                                Qty: <span
                                                    style="font-weight: normal;">
                                                    <?php echo e($batch['batch_qty']); ?>

                                                </span></h4>
                                            <?php $totalQty += $batch['batch_qty']; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <h4> Total Qty: <span
                                                style="font-weight: normal;">
                                                <?php echo e($totalQty); ?> </span>
                                        </h4>
                                    <?php else: ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                <?php
                                    // Group by v_no first
                                    $groupedByVno = [];
                                    foreach (
                                        $groupedJobDetails
                                        as $detail
                                    ) {
                                        $v_no = $detail['v_no'] ?? null;
                                        if ($v_no) {
                                            $groupedByVno[
                                                $v_no
                                            ][] = $detail;
                                        }
                                    }
                                ?>

                                <?php $__currentLoopData = $groupedByVno; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_no => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        // Collect all values (keeping duplicates) while filtering out N/A/empty
                                        $departments = [];
                                        $designations = [];
                                        $employees = [];

                                        foreach ($details as $detail) {
                                            if (
                                                auth()->user()->is_admin ==
                                                    1 ||
                                                $detail['job_status'] ==
                                                    'Pending'
                                            ) {
                                                // Departments
                                                foreach (
                                                    $detail[
                                                        'departments'
                                                    ] ?? []
                                                    as $dept
                                                ) {
                                                    if (
                                                        $dept !== 'N/A' &&
                                                        !empty($dept)
                                                    ) {
                                                        $departments[] = $dept;
                                                    }
                                                }

                                                // Designations
                                                foreach (
                                                    $detail[
                                                        'designations'
                                                    ] ?? []
                                                    as $desig
                                                ) {
                                                    if (
                                                        $desig !== 'N/A' &&
                                                        !empty($desig)
                                                    ) {
                                                        $designations[] = $desig;
                                                    }
                                                }

                                                // Employees
                                                foreach (
                                                    $detail['employees'] ??
                                                        []
                                                    as $emp
                                                ) {
                                                    if (
                                                        $emp !== 'N/A' &&
                                                        !empty($emp)
                                                    ) {
                                                        $employees[] = $emp;
                                                    }
                                                }
                                            }
                                        }
                                    ?>

                                    <?php if(count($departments) > 0 || count($designations) > 0 || count($employees) > 0): ?>
                                        <div class="job-detail-group">
                                            <?php if(count($departments) > 0): ?>
                                                <h5>Departments:
                                                    <?php echo e(implode(', ', $departments)); ?>

                                                </h5>
                                            <?php endif; ?>

                                            <?php if(count($designations) > 0): ?>
                                                <h5>Designation:
                                                    <?php echo e(implode(', ', $designations)); ?>

                                                </h5>
                                            <?php endif; ?>


                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                <h5>Custom Description:
                                    <?php $__currentLoopData = $groupedJobDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->is_admin == 1 || $detail['job_status'] == 'Pending'): ?>
                                            <?php echo e($detail['custom_descr'] ?? 'N/A'); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </h5>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>













                                </div>
                            </div>
                        </div>
                    </div>
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
        ->where('app_name', 'jobSheet')
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
        ->where('app_name', 'jobSheet')
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
        ->where('app_name', 'jobSheet')
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

function printAdminTable() {
<?php if(auth()->user()->is_admin == 1): ?>
// For admin, show all content
executePrint();
<?php else: ?>
alert('You are not authorized to use Admin Print!');
return false;
<?php endif; ?>
}

function printUserTable() {
// For regular users, we'll filter content before printing
<?php if(auth()->user()->is_admin == 0): ?>
// Check if there are any pending jobs to print
const hasPendingJobs = <?php echo json_encode(collect($groupedJobDetails)->contains('job_status', 'Pending'), 512) ?>;
if (!hasPendingJobs) {
    alert('No pending jobs available to print!');
    return false;
}
<?php endif; ?>
executePrint();
}

function executePrint() {
const printSection = document.getElementById('print-section');
const printWindow = window.open('', '_blank');

printWindow.document.write(`
<html>
<head>
<title>Job Sheet Print</title>
<style>
    body { font-family: Arial; 
    margin: 20px; 
    line-height: 1.2; }
    h3, h5, h4 { margin: 16px 4px ; }
    table { width: 100%; border-collapse: collapse; margin-top: 5px; }
    td { padding: 3px; vertical-align: top; }
    img { max-width: 200px; max-height: 200px; }
</style>
</head>
<body>${printSection.innerHTML}
<script>
    window.onload = function() {
        window.print();
        setTimeout(() => window.close(), 100);
    };
<\/script>
</body>
</html>
`);
printWindow.document.close();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/job_sheet/index.blade.php ENDPATH**/ ?>