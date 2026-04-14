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
                <h3 class="page-title">Dye Return</h3>
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
                    <div class="col-6">
                        <form action="<?php echo e(route('dye_return.reports')); ?>" method="GET" class="form-inline"
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
                                    <label for="account_title" class="sr-only">Status</label>
                                    <select name="status" class="form-control select2">
                                        <option value="">All</option>

                                        <option value="official" <?php echo e($status=='official' ? 'selected' : ''); ?>>Official
                                        </option>
                                        <option value="unofficial" <?php echo e($status=='unofficial' ? 'selected' : ''); ?>>
                                            Unofficial</option>

                                    </select>

                                </div>
                                <div class="form-group col-xl-4 mt-2">
                                <label for="v_no" class="sr-only">Voucher Number</label>
                                <select name="v_no" class="form-control select2" data-toggle="select2">
                                    <option value="">Select Voucher</option>
                                    <?php $__currentLoopData = $vNo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($vNo); ?>" <?php echo e(request()->get('v_no') == $vNo ? 'selected' : ''); ?>>
                                            <?php echo e($vNo); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            
                    


                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a class="btn btn-success" href="<?php echo e(route('dye_return.list')); ?>" role="button"
                                        onclick="return checkPermission()">Add New</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Combined Data Table -->
        <div class="row">
            <div class="card">
                
                <div class="card-body">
                    
                    <div id="print-header" style="display:none;">
    <h3>Wastage Sale Details</h3>
    <h5>Start Date: <span id="display-start-date"><?php echo e(request()->get('start_date') ?? 'N/A'); ?></span></h5>
    <h5>End Date: <span id="display-end-date"><?php echo e(request()->get('end_date') ?? date('Y-m-d')); ?></span></h5>
</div>
                    <button type="button" class="btn btn-secondary" style="width: 100px;" onclick="printTable()">Print
                        Table</button>
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="col-12">
                                    <!--<h4>Transaction and Purchase Details</h4>-->
                                    <table id="combined-data-table"
                                        class="table table-striped dt-responsive nowrap w-100">
                                        <h4>Dye Return Details</h4>
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>V.No</th>
                                                <th class="no-print">Prepared By</th>
                                                <th>Account Title</th>
                                                <th>Item Title</th>
                                                <th>Qty</th>
                                                <th>Description</th>
                                                <th>Amount</th>
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
                                                <td class="no-print"><?php echo e($data->preparedby ?? 'N/A'); ?></td>
                                                <td><?php echo e($data->accounts->title ?? 'N/A'); ?></td>
                                                <td><?php echo e($data->dyereturns->items->item_code ?? 'N/A'); ?></td>
                                                 <td><?php echo e($data->dyereturns->qty ?? 'N/A'); ?></td>
                                                <td><?php echo e($data->description ?? 'N/A'); ?></td>
                                                <td><?php echo e($data->debit ?? 'N/A'); ?></td>
                                                <td>
                                                    <?php if(!empty($data->dyereturns->file_path)): ?>
                                                    <a href="<?php echo e(asset('storage/' . $data->dyereturns->file_path)); ?>"
                                                        target="_blank">
                                                        <p>YES</p>
                                                    </a>
                                                    <?php else: ?>
                                                    <p>NO</p>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="no-print">
                                                    <input type="checkbox" class="status-checkbox"
                                                        data-id="<?php echo e($data->id); ?>" <?php echo e($data->status == 'official' ?
                                                    'checked' : ''); ?>>
                                                </td>
                                                

                      <td class="no-print">
                        <?php if($data->dyereturns): ?> <!-- Check if plate return exists -->
                        <form action="<?php echo e(route('dye_return.destroy', $data->dyereturns->id)); ?>"
                          method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                          <?php echo csrf_field(); ?>
                          <?php echo method_field('DELETE'); ?>
                          <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Delete
                          </button>
                        </form>
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

    <script>

        function checkPermission() {
            let canAdd = <?php echo json_encode(auth()->user()->is_admin == 1 || (\App\Models\Right::where('user_id', auth()->user()->id)->where('app_name', 'dyePurchase')->first()->add ?? 0) == 1) ?>;
            if (!canAdd) {
                alert('You do not have Permission to Add');
                return false;
            }
            return true;
        }

        function checkPermissionEdit() {
            let canEdit = <?php echo json_encode(auth()->user()->is_admin == 1 || (\App\Models\Right::where('user_id', auth()->user()->id)->where('app_name', 'dyePurchase')->first()->edit ?? 0) == 1) ?>;
            if (!canEdit) {
                alert('You do not have Permission to Edit');
                return false;
            }
            return true;
        }

        function checkPermissionDel() {
            let canDelete = <?php echo json_encode(auth()->user()->is_admin == 1 || (\App\Models\Right::where('user_id', auth()->user()->id)->where('app_name', 'dyePurchase')->first()->del ?? 0) == 1) ?>;
            if (!canDelete) {
                alert('You do not have Permission to Delete');
                return false;
            }
            return true;
        }


        function confirmDelete(button) {
            if (confirm('Are you sure you want to delete this record from both tables? This action cannot be undone.')) {
                button.parentElement.submit();
            }
        }

// Function to format the date as YYYY-MM-DD
function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// Get today's date
const today = new Date();

// Format today's date
const endDate = formatDate(today);

// Set the value of the input element with ID 'end_date'
document.getElementById('end_date').value = endDate;

function printTable() {
    // Get the HTML content to print
    var printContents = document.getElementById('print-header').innerHTML;
    
    // Add Bootstrap print styles with full screen adjustments
    printContents += `
        <style>
            @media print {
                body {
                    font-family: Arial, sans-serif;
                    padding: 0;
                    margin: 0;
                }
                .table {
                    width: 100%;
                    margin-bottom: 0;
                    color: #212529;
                    border-collapse: collapse;
                    font-size: 12px;
                }
                .table thead th {
                    vertical-align: bottom;
                    border-bottom: 2px solid #dee2e6;
                    background-color: #f8f9fa !important;
                }
                .table td, .table th {
                    padding: 0.5rem;
                    vertical-align: top;
                    border-top: 1px solid #dee2e6;
                }
                .no-print, .no-print * {
                    display: none !important;
                }
                .table-striped tbody tr:nth-of-type(odd) {
                    background-color: rgba(0, 0, 0, 0.05);
                }
                .table-responsive {
                    display: block;
                    width: 100%;
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                    margin: 0;
                }
                h3 {
                    color: #343a40;
                    margin: 10px 0;
                    font-size: 18px;
                }
                h5 {
                    color: #6c757d;
                    margin: 8px 0;
                    font-size: 14px;
                }
                @page {
                    size: auto;  /* auto is the initial value */
                    margin: 0mm; /* this affects the margin in the printer settings */
                }
            }
        </style>
    `;
    
    // Get the table HTML
    var table = document.getElementById('combined-data-table').cloneNode(true);
    
    // Remove action buttons and status checkboxes from the cloned table
    var noPrintElements = table.querySelectorAll('.no-print');
    noPrintElements.forEach(function(element) {
        element.remove();
    });
    
    // Add the responsive wrapper and table to print contents
    printContents += '<div class="table-responsive">' + table.outerHTML + '</div>';
    
    // Create a new window for printing
    var originalContents = document.body.innerHTML;
    var printWindow = window.open('', '', 'height=1000,width=1200');
    
    printWindow.document.write(`
        <html>
            <head>
                <title>Wastage Sale Report</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body style="margin: 0; padding: 10px;">
                ${printContents}
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"><\/script>
            </body>
        </html>
    `);
    
    printWindow.document.close();
    
    // Wait for Bootstrap CSS to load before printing
    printWindow.onload = function() {
        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 500);
    };
}
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/dye_return/index.blade.php ENDPATH**/ ?>