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
            <li class="breadcrumb-item active">Cash Receipt</li>
          </ol>
        </div>
        <h3 class="page-title">Corrugation Return</h3>
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
            <form action="<?php echo e(route('corrugation_return.reports')); ?>" method="GET" class="form-inline" id="search-form">
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

                <div class="form-group col-xl-4 mt-2">
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
                <div class="form-group mt-3">
                  <button type="submit" class="btn btn-primary">Search</button>
                  <a class="btn btn-success" href="<?php echo e(route('corrugation_return.list')); ?>" role="button"
                    onclick="return checkPermission()">Add New</a>
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

                <table id="combined-data-table" class="table table-striped dt-responsive nowrap w-100">

                  <h4>Corrugation Return Details</h4>
                  <thead>
                    <tr>
                      <th class="no-print">Date</th>
                      <th class="no-print">V. No</th>
                      <th>Account</th>
                      <th>Corrugation Type</th>
                      <th>Qty</th>
                      <th>Rates</th>
                      <th>Size</th>
                      <th>Amount</th>
                      <th class="no-print">Status</th>
                      <th class="no-print">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $trndtl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td class="no-print"><?php echo e(\Carbon\Carbon::parse($data->date)->format('d-m-Y')); ?></td>
                      <td class="no-print"><?php echo e($data->v_type); ?>-<?php echo e($data->v_no); ?></td>
                      <td><?php echo e($data->accounts->title ?? 'N/A'); ?></td>
                      <td><?php echo e($data->corrugationreturns->item->item_code ?? 'N/A'); ?></td>

                      <td><?php echo e($data->corrugationreturns->qty ?? 'N/A'); ?></td>
                      <td><?php echo e($data->corrugationreturns->rate ?? 'N/A'); ?></td>
                      <td><?php echo e($data->corrugationreturns->size ?? 'N/A'); ?></td>
                      <td><?php echo e($data->corrugationreturns->amount ?? 'N/A'); ?></td>
                      <td class="no-print">
                        <input type="checkbox" class="status-checkbox" data-id="<?php echo e($data->id); ?>" <?php echo e($data->status ==
                        'official' ? 'checked' : ''); ?>>
                      </td>



                      <td class="no-print">
                        <?php if($data->corrugationreturns): ?> <!-- Check if plate return exists -->
                        <form action="<?php echo e(route('corrugation_return.destroy', $data->corrugationreturns->id)); ?>"
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
    <?php
    $isAdmin = auth() -> user() -> is_admin;
    $canAdd = true;

    if ($isAdmin == 0) {
      $userRights = \App\Models\Right:: where('user_id', auth() -> user() -> id)
        -> where('app_name', 'CorrugationReturn')
        -> first();
      $canAdd = $userRights && $userRights -> add == 1;
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
    $isAdmin = auth() -> user() -> is_admin;
    $canAdd = true;

    if ($isAdmin == 0) {
      $userRights = \App\Models\Right:: where('user_id', auth() -> user() -> id)
        -> where('app_name', 'CorrugationReturn')
        -> first();
      $canAdd = $userRights && $userRights -> edit == 1;
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
    $isAdmin = auth() -> user() -> is_admin;
    $canAdd = true;

    if ($isAdmin == 0) {
      $userRights = \App\Models\Right:: where('user_id', auth() -> user() -> id)
        -> where('app_name', 'CorrugationReturn')
        -> first();
      $canAdd = $userRights && $userRights -> del == 1;
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

    // Ensure the <h5> element contains the correct date and v_no
    const h5Element = document.querySelector('h5');
    if (h5Element) {
      h5Element.innerHTML = `
            <span style="flex: 1; font-size: 14px;">
                Date: <?php echo e($trndtl->isNotEmpty() ? \Carbon\Carbon::parse($trndtl->first()->created_at)->format('d-m-Y') : 'N/A'); ?>

            </span>
            <span style="margin-left: auto; font-size: 14px;">
              Voucher No: <?php echo e($trndtl->isNotEmpty() ? $trndtl->first()->v_type : 'N/A'); ?>-<?php echo e($trndtl->isNotEmpty() ? $trndtl->first()->v_no : 'N/A'); ?>

            </span>
        `;

      // Add Flexbox styling to the h5 element
      h5Element.style.display = 'flex';
      h5Element.style.justifyContent = 'space-between';
      h5Element.style.alignItems = 'center';
    }

    // Get the heading, sub-heading, and table content you want to print
    const headingContent = document.querySelector('h4').outerHTML;
    const subHeadingContent = document.querySelector('h5').outerHTML; // Get the <h5> content
    const tableContent = document.getElementById('combined-data-table').outerHTML;

    // Create a div to display the freight value on the right side (only if freight > 0)
    const freightContent = `
    <?php
        $freightDetails = $trndtl->pluck('corrugationreturns')->filter(function ($detail) {
            return $detail->freight > 0; // Only include freight values greater than 0
        });
        $totalQtys = $trndtl->pluck('corrugationreturns')->where('vorcher_no')->sum('qty');
    ?>

    <?php if($freightDetails->isNotEmpty()): ?>
        <div style="display: flex; justify-content: flex-end; margin-top: 10px; font-size: 14px;">
            <strong>Freight:</strong>
            <?php $__currentLoopData = $freightDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($detail->freight_type == 'Bilty'): ?>
                    Bilty <?php echo e($detail->freight); ?><br>
                <?php elseif($detail->freight_type == 'Per Piece'): ?>
                  Per Piece <?php echo e($totalQtys); ?> * <?php echo e($detail->freight / $totalQtys); ?> = <?php echo e($detail->freight); ?><br>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
`;

    const originalContents = document.body.innerHTML;

    // Replace body content with the heading, sub-heading, table, and freight HTML for printing
    document.body.innerHTML = `
        <html>
            <head>
                <title>Print Table</title>
                
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        font-size: 12px; /* Adjusted font size */
                        margin: 0; /* Remove default body margin */
                        padding: 0; /* Remove default body padding */
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin: 0; /* Remove table margin */
                        padding: 0; /* Remove table padding */
                    }

                    th, td {
                        border: 1px solid #ddd;
                        padding: 2px; /* Reduced cell padding */
                    }

                    th {
                        background-color: #f2f2f2;
                        text-align: left;
                    }

                    .no-print {
                        display: none;
                    }

                    /* Print-specific styles */
                    @media print {
                        @page {
                            margin: 20px; /* Set margin to 20px on all sides */
                        }

                        body {
                            margin: 0; /* Ensure no additional body margin */
                            padding: 0; /* Ensure no additional body padding */
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

    // Trigger print dialog
    window.print();

    // Restore the original page content after printing
    document.body.innerHTML = originalContents;

    // Reattach event listeners or reload the page if needed
    window.location.reload();
  }

  function confirmDelete(button) {
    if (confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
      button.parentElement.submit(); // Submit the form if confirmed
    }
  }
  const today = new Date().toISOString().split('T')[0];

  // Set the value of the input field to the current date
  document.getElementById('end_date').value = today;
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/corrugation_return/index.blade.php ENDPATH**/ ?>