

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
                <h3 class="page-title">Gate-Pass Out</h3>
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
                <div class="col-11">
                    <form action="<?php echo e(route('gate_pass_out.reports')); ?>" method="GET" class="form-inline" id="search-form">
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-5 col-sm-8">
                                <label for="start_date" class="sr-only">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo e(request()->get('start_date')); ?>">
                            </div>
                            <div class="form-group col-lg-2 col-md-5 col-sm-8">
                                <label for="end_date" class="sr-only">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo e(request()->get('end_date')); ?>">
                            </div>
                            <div class="form-group col-lg-2 col-md-5 col-sm-8">
                                <label for="status" class="sr-only">Status</label>
                                <select name="status" class="form-control select2">
                                    <option value="">All</option>
                                    <option value="official" <?php echo e(request()->get('status') == 'official' ? 'selected' : ''); ?>>Official</option>
                                    <option value="unofficial" <?php echo e(request()->get('status') == 'unofficial' ? 'selected' : ''); ?>>Unofficial</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-lg-2 col-md-6 col-sm-12">
    <label for="account_id" class="sr-only">Account Title</label>
    <select name="account_id" class="form-control select2" data-toggle="select2">
        <option value="">Select Account</option>
        <?php $__currentLoopData = $accountId; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($id); ?>" <?php echo e(request()->get('account_id') == $id ? 'selected' : ''); ?>>
                <?php echo e($title); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
                            <div class="form-group col-lg-2 col-md-6 col-sm-12">
                                <label for="v_no" class="sr-only">Voucher Number</label>
                                <select name="v_no" class="form-control select2" data-toggle="select2">
                                    <option value="">Select Voucher</option>
                                    <?php $__currentLoopData = $vNoList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($vNo); ?>" <?php echo e(request()->get('v_no') == $vNo ? 'selected' : ''); ?>>
                                            <?php echo e($vNo); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="description" class="sr-only">Description</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Search Description" value="<?php echo e(request()->get('description')); ?>">
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a class="btn btn-success" href="<?php echo e(route('gate_pass_out.list')); ?>" role="button" onclick="return checkPermission()">Add New</a>
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
                <button type="button" class="btn btn-secondary" style="width: 100px;" onclick="printTable()">Print Table</button>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="col-12">
                                <!--<h4>Transaction and Purchase Details</h4>-->
                                <table id="combined-data-table" class="table table-striped dt-responsive nowrap w-100">
                                     <h4>Gate-Pass Out Details</h4>
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>V.No</th>
                                            <th>Prepared By</th>
                                            <th>Account Title</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                            <th>Total</th>
                                            <th>Img</th>
                                            <th class="no-print">Status</th>
                                            <th class="no-print">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $trndtl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(\Carbon\Carbon::parse($data->date)->format('d-m-Y')); ?></td>
                                            <td><?php echo e($data->v_type); ?>-<?php echo e($data->v_no); ?></td>
                                            <td><?php echo e($data->preparedby ?? 'N/A'); ?></td>

                                            <!-- Account Title (Party) -->
                                            <td><?php echo e($data->accounts->title ?? 'N/A'); ?></td>

                                            <!-- Sale Title (Cash Account) -->

                                            <td><?php echo e($data->description ?? 'N/A'); ?></td>
                                            <td><?php echo e($data->gatepassout->qty ?? 'N/A'); ?></td>
                                            <td><?php echo e($data->gatepassout->rate ?? 'N/A'); ?></td>
                                            <td><?php echo e($data->gatepassout->total ?? 'N/A'); ?></td>
                                            
                                            <td>
                                                    <?php if(!empty($data->gatepassout->file_path)): ?>
                                                    <a href="<?php echo e(asset('storage/' . $data->gatepassout->file_path)); ?>"
                                                        target="_blank">
                                                        <p>Img</p>
                                                    </a>
                                                    <?php else: ?>
                                                    <p>No Img</p>
                                                    <?php endif; ?>
                                                </td>


                                            <td class="no-print">
                                                <input type="checkbox" class="status-checkbox" data-id="<?php echo e($data->id); ?>" <?php echo e($data->status == 'official' ? 'checked' : ''); ?>>
                                            </td>

                                            <td class="no-print">
                                                <form action="<?php echo e(route('gate_pass_out.delete', ['id' => $data->id])); ?>" method="POST" style="display:inline;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">Delete</button>
</form>
                                                <a href="<?php echo e(route('gate_pass_out.edit', ['v_no' => $data->v_no])); ?>" class="btn btn-warning btn-sm" onclick="return checkPermissionEdit()">Edit</a>
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
                ->where('app_name', 'gatePassout')
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
                ->where('app_name', 'gatePassout')
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
    
     function confirmDelete(button) {
        // Check permission before showing confirmation
        if (!checkPermissionDel()) {
            return false; // Stop execution if no permission
        }

        if (confirm('Are you sure you want to delete this record from both tables? This action cannot be undone.')) {
            button.parentElement.submit();
        }
    }

    function checkPermissionDel() {
        let canDelete = <?php echo json_encode(auth()->user()->is_admin == 1 || 
            (\App\Models\Right::where('user_id', auth()->user()->id)
            ->where('app_name', 'gatePassout')
            ->value('del') == 1)) ?>;

        if (!canDelete) {
            alert('You do not have Permission to Delete');
            return false; // Prevent deletion
        }

        return true; // Allow deletion
    }
    
    
function printTable() {
    // Hide elements with 'no-print' class
    const elementsToHide = document.querySelectorAll('.no-print');
    elementsToHide.forEach(el => el.style.display = 'none');

    // Get the heading and table content you want to print
    const headingContent = document.querySelector('h4').outerHTML;
    const tableContent = document.getElementById('combined-data-table').outerHTML;
    const originalContents = document.body.innerHTML;

    // Replace body content with the heading and table HTML for printing
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
                </style>
            </head>
            <body>
                ${headingContent}
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
    

    const today = new Date().toISOString().split('T')[0];

    // Set the value of the input field to the current date
    document.getElementById('end_date').value = today;
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/sale_reports/index4.blade.php ENDPATH**/ ?>