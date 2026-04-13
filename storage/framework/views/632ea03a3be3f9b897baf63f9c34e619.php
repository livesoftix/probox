

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
                <h3 class="page-title">General Billing</h3>
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

    <!-- Search Form -->
    <div class="row">
        <div class="card mt-2">
            <div class="card-body">
                <div class="tab-content">
                    <div class="col-12">
                        <form action="<?php echo e(route('general_billing.report')); ?>" method="GET" class="form-inline" id="search-form">
    <div class="row">
        <!-- Start Date -->
        <div class="form-group col-xl-2">
            <label for="start_date" class="sr-only">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo e(request('start_date')); ?>">
        </div>
        <!-- End Date -->
        <div class="form-group col-xl-2">
            <label for="end_date" class="sr-only">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo e(request('end_date')); ?>">
        </div>
        <!-- Status Dropdown -->
        <div class="form-group col-xl-2">
            <label for="account_title" class="sr-only">Status</label>
            <select name="status" class="form-control select2">
                <option value="">All</option>
                <option value="official" <?php echo e(request('status') == 'official' ? 'selected' : ''); ?>>Official</option>
                <option value="unofficial" <?php echo e(request('status') == 'unofficial' ? 'selected' : ''); ?>>Unofficial</option>
            </select>
        </div>
        
        <div class="form-group col-xl-2">
            <label class="sr-only">Billing Number</label>
            <select name="billing_no" class="form-control select2" data-toggle="select2">
                <option value="">Select</option>
                <?php $__currentLoopData = $generalBillings->unique('party_no'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $billing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($billing->party_no ?? 'N/A'); ?>" <?php echo e(request('billing_no') == ($billing->party_no ?? 'N/A') ? 'selected' : ''); ?>>
                        <?php echo e($billing->party_no ?? 'N/A'); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        <div class="form-group col-xl-2">
            <label class="sr-only">Product Type</label>
            <select name="product_type" class="form-control select2" data-toggle="select2">
                <option value="">Select</option>
                <?php $__currentLoopData = $generalBillings->unique('product_type'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $billing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($billing->product_type ?? 'N/A'); ?>" <?php echo e(request('product_type') == ($billing->product_type ?? 'N/A') ? 'selected' : ''); ?>>
                        <?php echo e($billing->product_type ?? 'N/A'); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        <div class="form-group col-xl-2">
            <label class="sr-only">Party</label>
            <select name="party_name" class="form-control select2" data-toggle="select2">
                <option value="">Select</option>
                <?php $__currentLoopData = $generalBillings->unique('party_name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $billing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($billing->party_name ?? 'N/A'); ?>" <?php echo e(request('party_name') == ($billing->party_name ?? 'N/A') ? 'selected' : ''); ?>>
                        <?php echo e($billing->party_name ?? 'N/A'); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        <!-- Show Previous Balance Radio Buttons -->
        <div class="form-group col-xl-2">
            <label class="form-label">Show Previous Balance?</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="show_prev_balance" id="showPrevYes" value="1" <?php echo e(request('show_prev_balance', '1') == '1' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="showPrevYes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="show_prev_balance" id="showPrevNo" value="0" <?php echo e(request('show_prev_balance', '1') == '0' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="showPrevNo">No</label>
            </div>
        </div>
        
        <!-- Search and Add New Buttons -->
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Search</button>
            <a class="btn btn-success" href="<?php echo e(route('general_billing.list')); ?>" role="button" onclick="return checkPermission()">Add New</a>
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
                                    <h3>General Billing Details</h3>
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
                                         <?php $__currentLoopData = $generalBillings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $general): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
            <td><?php echo e(\Carbon\Carbon::parse($general->updated_at)->format('Y-m-d') ?? 'N/A'); ?></td>
            <td><?php echo e($general->party_type ?? 'N/A'); ?>-<?php echo e($general->party_no ?? 'N/A'); ?> </td>
            <td><?php echo e($general->party_name ?? 'N/A'); ?> </td>
            <td><?php echo e($general->item_name ?? 'N/A'); ?> </td>
            <td><?php echo e($general->amount ?? 'N/A'); ?> </td>

            <td class="no-print">
   
    <form action="<?php echo e(route('general_billing.destroy', $general->id)); ?>" method="POST" style="display:inline-block;" onclick="return checkPermissionDel()">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</button>
    </form>
</td>
            
            
            
            
            
            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <!-- Second Table -->
                                
                                
                                
                                <table id="print-data-table" class="table table-striped dt-responsive nowrap w-100" style="display: none;">
                                    <div style="display: none;">
    <h2><?php echo e(request('status') == 'official' ? 'Printing Cell' : 'Rizwan Packages'); ?></h2>
    <!-- Remove the direct access to updated_at on the collection -->
    <div style="display: flex; justify-content: space-between; align-items: center;">
    <h3 style="margin: 0;">Date: <?php echo e($generalBillings->first() ? \Carbon\Carbon::parse($generalBillings->first()->updated_at)->format('Y-m-d') : 'N/A'); ?></h3>
    <h3 style="margin: 0;">Invoice #: <?php echo e($generalBillings->first()->party_no ?? 'N/A'); ?></h3>
</div>
    <h3>Name: <?php echo e($generalBillings->first()->party_name  ?? 'N/A'); ?></h3>
    
    </div>
    <thead>
        <tr>
            <th>Date</th>
            <th>V No</th>
            <th>Poduct Type</th>
            <th>Item</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Freight</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $grandTotal = 0; // Initialize grand total variable
    ?>
    <?php $__currentLoopData = $generalBillings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $general): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e(\Carbon\Carbon::parse($general->updated_at)->format('Y-m-d') ?? 'N/A'); ?></td>
        <td><?php echo e($general->v_no ?? 'N/A'); ?> </td>
        <td><?php echo e($general->product_type ?? 'N/A'); ?> </td>
        <td><?php echo e($general->item_name ?? 'N/A'); ?> </td>
        <td><?php echo e($general->qty ?? 'N/A'); ?> </td>
        <td><?php echo e($general->rate ?? 'N/A'); ?> </td>
        <td><?php echo e($general->freight ?? 'N/A'); ?> </td>
        <td><?php echo e($general->amount ?? 'N/A'); ?> </td>
    </tr>
    <?php
        $grandTotal += $general->amount ?? 0; // Add each amount to grand total
    ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td colspan="7" style="text-align: right;"><strong>Grand Total:</strong></td>
        <td><strong><?php echo e(number_format($grandTotal, 2)); ?></strong></td>
    </tr>
</tbody>
    
<tfoot>
<tr>
            <td colspan="3" style="text-align: right; font-weight: bold;">Amount of this Month: </td>
            <td colspan="5" style="text-align: left; font-weight: bold;"><?php echo e(number_format($grandTotal, 2)  ?? 'N/A'); ?></td>
        </tr>
        <?php if(request('show_prev_balance', '1') == '1'): ?>
        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold;">Previous Balance: </td>
            <td colspan="5" style="text-align: left;font-weight: bold;">
    <?php echo e($generalBillings->first() ? number_format($generalBillings->first()->pre_bal, 2) : 'N/A'); ?>

</td>
        </tr>
        <tr>
    <td colspan="3" style="text-align: right; font-weight: bold;">Total: </td>
    <td colspan="5" style="text-align: left; font-weight: bold;">
        <?php if($generalBillings->first()): ?>
            <?php echo e(number_format($generalBillings->first()->pre_bal + $grandTotal, 2)); ?>

        <?php else: ?>
            N/A
        <?php endif; ?>
    </td>
</tr>
        <?php else: ?>
        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold;">Total: </td>
            <td colspan="5" style="text-align: left; font-weight: bold;"><?php echo e(number_format($grandTotal, 2)); ?></td>
        </tr>
        <?php endif; ?>
</tfoot>
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
                ->where('app_name', 'generalbilling')
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
                ->where('app_name', 'generalbilling')
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
                ->where('app_name', 'generalbilling')
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

</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/general_billing/index.blade.php ENDPATH**/ ?>