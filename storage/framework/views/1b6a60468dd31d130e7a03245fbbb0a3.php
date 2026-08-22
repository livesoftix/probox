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
                        <li class="breadcrumb-item active">Breaking Wage DC Department</li>
                    </ol>
                </div>
                <h3 class="page-title">Breaking Delivery Challan Department</h3>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
     <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Search Form -->
    <div class="row">
        <div class="card mt-2">
            <div class="card-body">
                <div class="tab-content">
                    <div class="col-12">
                        <form action="<?php echo e(route('breaking_wage_dc.report')); ?>" method="GET" class="form-inline" id="search-form">
     <div class="row">

    <div class="form-group col-xl-2">
        <label>Start Date</label>
        <input type="date"
               class="form-control"
               name="start_date"
               value="<?php echo e(request('start_date')); ?>">
    </div>

    <div class="form-group col-xl-2">
        <label>End Date</label>
        <input type="date"
               class="form-control"
               name="end_date"
               value="<?php echo e(request('end_date')); ?>">
    </div>
<div class="form-group col-xl-2">
    <label>Batch No</label>

    <select name="batch_no" class="form-control select2" data-toggle="select2">
        <option value="">All Batches</option>

        <?php $__currentLoopData = $batchList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($batch->batch_no); ?>"
                <?php echo e(request('batch_no') == $batch->batch_no ? 'selected' : ''); ?>>
                <?php echo e($batch->batch_no); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>


<div class="form-group col-xl-2">
    <label>Product</label>

    <select name="product" class="form-control select2" data-toggle="select2">
        <option value="">All Products</option>

        <?php $__currentLoopData = $productList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($product->prod_id); ?>"
                <?php echo e(request('product') == $product->product_name ? 'selected' : ''); ?>>
                <?php echo e($product->product_name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>


<div class="form-group col-xl-2">
    <label>Employee</label>

    <select name="employee" class="form-control select2" data-toggle="select2">
        <option value="">All Employees</option>

        <?php $__currentLoopData = $employeeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($employee->id); ?>"
                <?php echo e(request('employee') == $employee->id ? 'selected' : ''); ?>>      
<?php echo e($employee->fname); ?>

<?php echo e($employee->lname); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
  

    <div class="form-group col-xl-2">
        <label>Status</label>

        <select name="status" class="form-control select2">
            <option value="">All</option>
            <option value="official" <?php echo e(request('status')=='official'?'selected':''); ?>>Official</option>
            <option value="unofficial" <?php echo e(request('status')=='unofficial'?'selected':''); ?>>Unofficial</option>
        </select>
    </div>


    <div class="form-group mt-3">
        <button class="btn btn-primary">Search</button>

        <a href="<?php echo e(route('breaking_wage_dc.list')); ?>"
           class="btn btn-success"
           onclick="return checkPermission()">
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
                <!-- First Table -->
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="col-12">
                                <table id="combined-data-table" class="table table-striped dt-responsive nowrap w-100">
                                    <h3>Breaking Department Details</h3>
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Breaking DC</th>
                                              <th>Employee</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    <?php
        $processedEntries = []; // Array to track processed entries
    ?>
    
    <?php $__currentLoopData = $WageBreakings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $general): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            // Create a unique key for each entry (adjust based on what makes an entry unique)
            $entryKey = $general->b_no . '-' . $general->employee_name . '-' . $general->total_amount;
            
            // Skip if this entry has already been processed
            if (in_array($entryKey, $processedEntries)) {
                continue;
            }
            
            // Add to processed entries
            $processedEntries[] = $entryKey;
        ?>
        
        <tr>
            <td><?php echo e(\Carbon\Carbon::parse($general->updated_at)->format('Y-m-d') ?? 'N/A'); ?></td>
            <td><?php echo e($general->v_type ?? 'N/A'); ?>-<?php echo e($general->b_no ?? 'N/A'); ?></td>
           <td>
    <?php echo e($general->employee_names ?: 'N/A'); ?>

</td>
            
           <td>
    <?php echo e($general->total_amount - $general->total_deduction); ?>

</td>
<td class="no-print">

    <a href="<?php echo e(route('breaking_wage_dc.edit', $general->b_no)); ?>"
       class="btn btn-warning btn-sm">
        Edit
    </a>


    <a href="<?php echo e(route('breaking_wage_dc.print', $general->b_no)); ?>"
       target="_blank"
       class="btn btn-primary btn-sm">
        Print
    </a>


    <form action="<?php echo e(route('breaking_wage_dc.destroy', $general->id)); ?>"
          method="POST"
          style="display:inline-block;"
          onclick="return confirm('Are you sure you want to delete this transaction?')">

        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>

        <button type="submit"
                class="btn btn-danger btn-sm"
                onclick="return checkPermissionDel()">
            Delete
        </button>

    </form>

</td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <tr style="font-weight: bold; background-color: #f5f5f5;">
    <td colspan="3" class="text-end">
        Grand Total
    </td>

    <td>
        <?php echo e(number_format($grandTotal, 2)); ?>

    </td>

    <td></td>
</tr>
</tbody>
                                </table>
                                <!-- Second Table -->
                                
                                
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
                ->where('app_name', 'Breakingwages')
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
                ->where('app_name', 'breakingwages')
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
                ->where('app_name', 'breakingwages')
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
    // Show the elements to be printed
    const printHeader = document.querySelector('div[style="display: none;"]');
    const printTable = document.getElementById('print-data-table');
    printHeader.style.display = 'block';
    printTable.style.display = 'table';

    // Get content for printing
    const headerContent = printHeader.outerHTML;
    const tableContent = printTable.outerHTML;
    const originalContents = document.body.innerHTML;

    // Replace body content with the header and table content for printing
    document.body.innerHTML = `
        <html>
            <head>
                <title>Print Table</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        font-size: 12px;
                        margin: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 10px;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 6px;
                        text-align: left;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                    h2, h3 {
                        margin: 5px 0;
                    }
                    .text-right {
                        text-align: right;
                    }
                    .text-left {
                        text-align: left;
                    }
                
                    .flex-between {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }
                </style>
            </head>
            <body>
                ${headerContent}
                ${tableContent}
            </body>
        </html>
    `;

    // Trigger print dialog
    window.print();

    // Restore original content and hide the elements again
    document.body.innerHTML = originalContents;
    printHeader.style.display = 'none';
    printTable.style.display = 'none';

    // Reattach event listeners or reload the page if needed
    window.location.reload();
}

  const today = new Date().toISOString().split('T')[0];

// Set the value of the input field to the current date
document.getElementById('end_date').value = today;
$(document).ready(function () {
    $('.select2').select2({
        width: '100%'
    });
});

</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/wages/breaking/index.blade.php ENDPATH**/ ?>