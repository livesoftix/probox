<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        .action-icon {
            font-size: 20px;
            color: white;
            transition: transform 0.2s;
        }

        .action-icon:hover {
            transform: scale(1.1);
        }

        .action-btn {
            padding: 6px 10px;
            border-radius: 4px;
            margin: 0 2px;
        }
    </style>
<?php $__env->stopSection(); ?>
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
                    <h4 class="page-title">Product Registration</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->





        <div class="row">
            <div class="card mt-2">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="col-12">
                            <form action="<?php echo e(route('registration_form.reports')); ?>" method="GET" class="form-inline"
                                id="search-form">
                                <div class="row">
                                    <?php if(session('success')): ?>
                                        <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show"
                                            role="alert">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                            <strong>Success - </strong> <?php echo e(session('success')); ?>

                                        </div>
                                    <?php endif; ?>
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
                                    <!-- Party (Account) Dropdown -->
                                    <div class="form-group col-xl-2">
                                        <label for="account" class="form-label">Party</label>
                                        <select name="account" class="form-control select2" data-toggle="select2"
                                            id="account">
                                            <option value="">Select a Party</option>
                                            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product->aid); ?>"
                                                    <?php echo e(request()->get('account') == $product->aid ? 'selected' : ''); ?>>
                                                    <?php echo e($product->account->title ?? 'Select a Party'); ?>

                                                    <!-- Display account title -->
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- Country Dropdown -->
                                    <div class="form-group col-xl-2">
                                        <label for="country" class="form-label">Country</label>
                                        <select name="country" class="form-control select2" id="country"
                                            data-toggle="select2">
                                            <option value="">Select a Country</option>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product->country_id); ?>"
                                                    <?php echo e(request()->get('country') == $product->country_id ? 'selected' : ''); ?>>
                                                    <?php echo e($product->country->country_name ?? 'No Country'); ?>

                                                    <!-- Display country name -->
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- Product Name Dropdown -->
                                    <div class="form-group col-xl-2">
                                        <label for="productName" class="form-label">Product Name</label>
                                        <select id="productName" class="form-control select2" name="productName"
                                            data-toggle="select2">
                                            <option value="">Select a Product</option>
                                            <?php $__currentLoopData = $productNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product->prod_name); ?>"
                                                    <?php echo e(request('productName') == $product->prod_name ? 'selected' : ''); ?>>
                                                    <?php echo e($product->prod_name); ?> <!-- Display product name -->
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>





                                    <!-- Submit Button -->
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        <a href="<?php echo e(route('registration_form.list')); ?>">
                                            <button type="button" class="btn btn-success"
                                                onclick="return checkPermission()">Add Item</button>
                                        </a>
                                    </div>
                                </div>
                            </form>


                            <div class="row">

                                <div class="col-12">
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            <button type="button" class="btn btn-secondary" onclick="printTable()">
                                                Print Table
                                            </button>

                                            <div class="tab-content">
                                                <div class="tab-pane show active" id="basic-datatable-preview">
                                                    <div style="overflow-x: auto;">
                                                        <table id="basic-datatable"
                                                            class="table table-striped dt-responsive nowrap w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th>SR</th>
                                                                    <th class="no-print">Actions</th>
                                                                    <th>Date</th>
                                                                    <th>Product Name</th>
                                                                    <th>Product Type</th>
                                                                    <th>Party</th>
                                                                    <th>Country</th>
                                                                    <th>Item</th>
                                                                    <th>Grammage</th>
                                                                    <th>Length</th>
                                                                    <th>Width</th>
                                                                    <th>Product Rate</th>
                                                                    <th>Img</th>
                                                                    <th>Description</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr>
                                                                        <td><?php echo e($product->id); ?></td>
                                                                        <td class="no-print">
                                                                            <div
                                                                                class="d-flex gap-2 justify-content-center align-items-center">

                                                                                <!-- Show -->
                                                                                <a href="<?php echo e(route('registration_form.show', $product->id)); ?>"
                                                                                    class="btn btn-outline-info btn-sm d-flex align-items-center justify-content-center"
                                                                                    title="View Details">
                                                                                    <i class="uil uil-eye"></i>
                                                                                </a>

                                                                                <!-- Edit -->
                                                                                <a href="<?php echo e(route('registration_form.edit', $product->id)); ?>"
                                                                                    onclick="return checkPermissionEdit()"
                                                                                    class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center"
                                                                                    title="Edit Product">
                                                                                    <i class="uil uil-edit"></i>
                                                                                </a>

                                                                                <!-- Delete -->
                                                                                <form
                                                                                    action="<?php echo e(route('registration_form.destroy', $product->id)); ?>"
                                                                                    method="POST"
                                                                                    onsubmit="return confirm('Are you sure you want to delete this product?');"
                                                                                    style="display:inline;">
                                                                                    <?php echo csrf_field(); ?>
                                                                                    <?php echo method_field('DELETE'); ?>
                                                                                    <button type="submit"
                                                                                        class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center"
                                                                                        onclick="return checkPermissionDel()"
                                                                                        title="Delete Product">
                                                                                        <i class="uil uil-trash-alt"></i>
                                                                                    </button>
                                                                                </form>

                                                                            </div>
                                                                        </td>
                                                                        <td><?php echo e(\Carbon\Carbon::parse($product->updated_at)->format('m/d/Y h:i A')); ?>

                                                                        </td>
                                                                        <td><?php echo e($product->prod_name); ?></td>
                                                                        <td><?php echo e($product->product_type ?? 'N/A'); ?></td>
                                                                        <td><?php echo e($product->account->title ?? 'No Account'); ?>

                                                                        </td>
                                                                        <td><?php echo e($product->country->country_name ?? 'No Country'); ?>

                                                                        </td>
                                                                        <td><?php echo e($product->items->item_code ?? 'No Items'); ?>

                                                                        </td>
                                                                        <td><?php echo e($product->grammage); ?></td>
                                                                        <td><?php echo e($product->length); ?></td>
                                                                        <td><?php echo e($product->width); ?></td>
                                                                        <td><?php echo e($product->rate); ?></td>
                                                                        <td>
                                                                            <?php if(!empty($product->file_path)): ?>
                                                                                <a href="<?php echo e(asset('storage/' . $product->file_path)); ?>"
                                                                                    target="_blank">
                                                                                    <p>Img</p>
                                                                                </a>
                                                                            <?php else: ?>
                                                                                <p>No Img</p>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td><?php echo e($product->descr); ?></td>


                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                                <!-- end preview-->
                                            </div>
                                            <!-- end tab-content-->
                                        </div>
                                        <!-- end card body-->
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->
                        </div>

                        <!-- Print Function -->
                        <script>
                            function checkPermission() {
                                <?php
                                    $isAdmin = auth()->user()->is_admin;
                                    $canAdd = true;

                                    if ($isAdmin == 0) {
                                        $userRights = \App\Models\Right::where('user_id', auth()->user()->id)
                                            ->where('app_name', 'productRegistrations')
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
                                            ->where('app_name', 'productRegistrations')
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
                                            ->where('app_name', 'productRegistrations')
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
                                const elementsToHide = document.querySelectorAll(".no-print");
                                elementsToHide.forEach((el) => (el.style.display = "none"));

                                const printContents = document.getElementById("basic-datatable").outerHTML;
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
                        </script>

                        <style>
                            <style>.btn i {
                                font-size: 1rem;
                                /* small, balanced icon size */
                                line-height: 1;
                            }

                            .btn-sm {
                                padding: 4px 8px;
                                border-radius: 6px;
                            }
                        </style>

                        </style>
                    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/registration_form/index.blade.php ENDPATH**/ ?>