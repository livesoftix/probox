
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
                    <h4 class="page-title">Employee</h4>
                </div>
            </div>
        </div>

        <!-- end page title -->

        <div class="row">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Success - </strong> <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>


            <div class="row">

                <div class="card mt-2">
                    <div class="card-body">

                        <div class="tab-content">
                            <div class="col-6">
                                <form action="<?php echo e(route('employees.reports')); ?>" method="GET" class="form-inline"
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
                                            <label for="employee" class="sr-only">Status</label>
                                            <select name="employee" class="form-control select2">
                                                <option value="">All</option>
                                                <option value="official"
                                                    <?php echo e(request()->get('employee') == 'official' ? 'selected' : ''); ?>>
                                                    Official
                                                </option>
                                                <option value="unofficial"
                                                    <?php echo e(request()->get('employee') == 'unofficial' ? 'selected' : ''); ?>>
                                                    Unofficial
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-xl-4 mt-2">
                                            <label for="fname" class="sr-only">Name</label>
                                            <select name="fname" class="form-control select2" data-toggle="select2"
                                                data-placeholder="Select Name">
                                                <option value=""></option> <!-- Empty option for placeholder -->
                                                <?php $__currentLoopData = $employees->unique('fname'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($emp->fname); ?>"
                                                        <?php echo e(request()->get('fname') == $emp->fname ? 'selected' : ''); ?>>
                                                        <?php echo e($emp->fname); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-xl-4 mt-2">
                                            <label for="cnic_no" class="sr-only">CNIC</label>
                                            <select name="cnic_no" class="form-control select2" data-toggle="select2"
                                                data-placeholder="Select CNIC">
                                                <option value=""></option> <!-- Empty option for placeholder -->
                                                <?php $__currentLoopData = $employees->unique('cnic_no'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($emp->cnic_no); ?>"
                                                        <?php echo e(request()->get('cnic_no') == $emp->cnic_no ? 'selected' : ''); ?>>
                                                        <?php echo e($emp->cnic_no); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                            <a class="btn btn-success" href="<?php echo e(route('employees.list')); ?>" role="button"
                                                onclick="return checkPermission()">Add New</a>
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
                                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Sr</th>
                                                <th>Name</th>
                                                <th>Father Name</th>
                                                <th>Phone No</th>
                                                <th>Blood Group</th>
                                                <th>Address</th>
                                                <th>CNIC</th>
                                                <th>Department No</th>
                                                <th>CNIC Front</th>
                                                <th>CNIC Back</th>
                                                <th>Employee Type</th>
                                                <th class="no-print">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td><?php echo e($employee->fname); ?></td>
                                                    <td><?php echo e($employee->lname); ?></td>
                                                    <td><?php echo e($employee->phone_no); ?></td>
                                                    <td><?php echo e($employee->blood_group ?? 'N/A'); ?></td>
                                                    <td><?php echo e(Str::limit($employee->address, 30)); ?></td>
                                                    <td><?php echo e($employee->cnic_no ?? 'N/A'); ?></td>
                                                    <td><?php echo e($employee->department_no ?? 'N/A'); ?></td>

                                                    <td>
                                                        <?php if($employee->cnic_front_path): ?>
                                                            <a href="<?php echo e(asset('storage/' . $employee->cnic_front_path)); ?>"
                                                                target="_blank">
                                                                IMG
                                                            </a>
                                                        <?php else: ?>
                                                            No Img
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($employee->cnic_back_path): ?>
                                                            <a href="<?php echo e(asset('storage/' . $employee->cnic_back_path)); ?>"
                                                                target="_blank">
                                                                IMG
                                                            </a>
                                                        <?php else: ?>
                                                            No Img
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($employee->employee == 'offcial'): ?>
                                                            <span class="badge bg-success">Official</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning">Un-Official</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="no-print">
                                                        <div class="d-flex gap-1">
                                                            <!-- View -->
                                                            <a href="<?php echo e(route('employees.show', $employee->id)); ?>"
                                                               class="btn btn-icon btn-outline-info btn-sm"
                                                               title="View">
                                                                <i class="uil uil-eye"></i>
                                                            </a>
                                                            <!-- Edit -->
                                                            <a href="<?php echo e(route('employees.edit', $employee->id)); ?>"
                                                               class="btn btn-icon btn-outline-primary btn-sm"
                                                               title="Edit"
                                                               onclick="return checkPermissionEdit()">
                                                                <i class="uil uil-edit"></i>
                                                            </a>
                                                            <!-- Delete -->
                                                            <form action="<?php echo e(route('employees.destroy', $employee->id)); ?>"
                                                                  method="POST"
                                                                  class="d-inline"
                                                                  onsubmit="return handleDelete(event, '<?php echo e($employee->department_no ?? 'N/A'); ?>');">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit"
                                                                        class="btn btn-icon btn-outline-danger btn-sm"
                                                                        title="Delete">
                                                                    <i class="uil uil-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
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
                        ->where('app_name', 'addemployee')
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
                        ->where('app_name', 'addemployee')
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



        function handleDelete(event, departmentNo) {
            // Laravel blade check — convert PHP to JS
            let canDelete = <?php echo json_encode(auth()->user()->is_admin == 1 ||
                    \App\Models\Right::where('user_id', auth()->user()->id)->where('app_name', 'addemployee')->first()?->del == 1) ?>;

            if (!canDelete) {
                alert('You do not have Permission to Delete');
                event.preventDefault();
                return false;
            }

            if (departmentNo !== 'N/A') {
                alert('Delete from department first');
                event.preventDefault();
                return false;
            }

            if (!confirm('Are you sure you want to delete this employee?')) {
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/employees/index.blade.php ENDPATH**/ ?>