<?php $__env->startSection('content'); ?>
<div class="container-fluid">
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
                <h4 class="page-title">General Job Sheet</h4>
            </div>
        </div>
    </div>

    <!-- end page title -->

    <div class="row">
        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Success - </strong> <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <div class="row">

            <div class="card mt-2">
                <div class="card-body">

                    <div class="tab-content">
                        <div class="col-6">
                            <form action="<?php echo e(route('general_job_sheet.report')); ?>" method="GET" class="form-inline" id="search-form">
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
            <label for="employee" class="sr-only">Status</label>
            <select name="employee" class="form-control select2">
                <option value="">All</option>
                <option value="official" <?php echo e(request()->get('employee') == 'official' ? 'selected' : ''); ?>>
                    Official
                </option>
                <option value="unofficial" <?php echo e(request()->get('employee') == 'unofficial' ? 'selected' : ''); ?>>
                    Unofficial
                </option>
            </select>
        </div>
    
        <div class="form-group col-xl-4 mt-2">
            <label for="v_no" class="form-label">JS No</label>
            <select name="v_no" class="form-control select2" data-toggle="select2" data-placeholder="Select JS No">
                <option value="">Select JS No</option>
                <?php $__currentLoopData = $vNos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($vNo); ?>" <?php echo e(request()->get('v_no') == $vNo ? 'selected' : ''); ?>>
                        <?php echo e($vNo); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
                                    
        <div class="form-group col-xl-4 mt-2">
    <label for="account_id" class="form-label">Party</label>
    <select name="account_id" class="form-control select2" data-toggle="select2" data-placeholder="Select Customer">
        <option value="">Select Party</option>
        <?php $__currentLoopData = $accountIds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($id); ?>" <?php echo e(request()->get('account_id') == $id ? 'selected' : ''); ?>>
                <?php echo e($title); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
  
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Search</button>
            <a class="btn btn-success" href="<?php echo e(route('general_job_sheet.list')); ?>" 
               role="button" onclick="return checkPermission()">Add New</a>
        </div>
    </div>
</form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-12">
         
            
            <!-- Print Button -->
            <div class="card mt-2">
                <div class="card-body">
                    <button type="button" class="btn btn-secondary" onclick="printTable()">Print Table</button>
                 
                    <div class="tab-content">
                        <div class="tab-pane show active" id="basic-datatable-preview">
                            <div style="overflow-x: auto;">
   
   <div class="table-responsive">
                       <table class="table table-striped dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>Date</th>
            <th>V No</th>
            <th>Party</th>
            <th>Purchase Type</th>
            <th>Item</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $generalJobSheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $general): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(\Carbon\Carbon::parse($general->updated_at)->format('Y-m-d') ?? 'N/A'); ?></td>
            <td><?php echo e('GJS'); ?>-<?php echo e($general->v_no ?? 'N/A'); ?> </td>
<td><?php echo e($general->account->title ?? 'N/A'); ?></td>
            <td><?php echo e($general->product_type ?? 'N/A'); ?></td>
            <td><?php echo e($general->item_name ?? 'N/A'); ?></td>
            <td><?php echo e($general->qty ?? 'N/A'); ?></td>
            <td><?php echo e($general->rate ?? 'N/A'); ?></td>
            <td><?php echo e($general->description ?? 'N/A'); ?></td>
          
            <td class="no-print">
    <a href="<?php echo e(route('general_job_sheet.edit', $general->id)); ?>" class="btn btn-warning btn-sm" onclick="return checkPermissionEdit()">Edit</a>
   
    <form action="<?php echo e(route('general_job_sheet.destroy', $general->id)); ?>" method="POST" style="display:inline-block;" onclick="return checkPermissionDel()">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</button>
    </form>
</td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
                    </div>
   
   
   
   
</div>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
</div>
<!-- Print Function -->
<script>
    
    function checkPermission() {
        <?php
        $isAdmin = auth()->user()->is_admin;
        $canAdd = true;

        if ($isAdmin == 0) {
            $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                ->where('app_name', 'generaljobSheet')
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
                ->where('app_name', 'generaljobSheet')
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
                ->where('app_name', 'generaljobSheet')
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

// Set the value of the input field to the current date
document.getElementById('end_date').value = today;

    function printTable() {
        // Hide elements with 'no-print' class
        const elementsToHide = document.querySelectorAll('.no-print');
        elementsToHide.forEach(el => el.style.display = 'none');

        const printContents = document.getElementById('basic-datatable').outerHTML;
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
                            .no-print{
                                background-color: #f2f2f2;
                            }
                        </style>
                    </head>
                    <body>
                        ${printContents}
                    </body>
                </html>
            `;

        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload(); // Reload to restore the original page content
    }
    
    $(document).ready(function() {
    $('.select2').select2();
});

 
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/general_job_sheet/index.blade.php ENDPATH**/ ?>