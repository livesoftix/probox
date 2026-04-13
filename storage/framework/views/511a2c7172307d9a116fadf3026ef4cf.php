
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <!-- start page title -->
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
                    <h4 class="page-title">Department Designation</h4>
                </div>
            </div>

        </div>
        <div class="row">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Success - </strong> <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <div class="col-12">
                <a href="<?php echo e(route('designation.list')); ?>"><button type="button" class="btn btn-primary" onclick="return checkPermission()">Add
                        Designation</button></a>
                <button type="button" class="btn btn-secondary" onclick="printTable()">Print Table</button>
                <!-- Print Button -->
                <div class="card mt-2">
                    <div class="card-body">
                        <h4 class="header-title">Department Name</h4>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="basic-datatable-preview">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th class="no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $printSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $print): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td><?php echo e($print->name); ?></td>
                                                <td class="no-print">
                                                 <form action="<?php echo e(route('designation.destroy', $print->id)); ?>" method="POST" style="display: inline;" onclick="return confirm('Are you sure you want to delete this item?')">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <button type="submit" class="btn btn-danger" style="margin-left: 2px;"   onclick="return checkPermissionDel()">Delete</button>
</form>
        
         <a href="<?php echo e(route('designation.edit', $print->id)); ?>" class="btn btn-warning  "   onclick="return checkPermissionEdit()">Edit</a>
        
        </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
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
                ->where('app_name', 'adddesignation')
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
                ->where('app_name', 'adddesignation')
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
                ->where('app_name', 'adddesignation')
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
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/designation/index.blade.php ENDPATH**/ ?>