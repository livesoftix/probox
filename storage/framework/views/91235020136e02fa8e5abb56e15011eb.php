 
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
                    <h4 class="page-title">Accounts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="card mt-2">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="col-12">
                            <form action="#" method="GET" class="form-inline" id="search-form">
    
                                     
                                        <a href="<?php echo e(route('create_account.list')); ?>">
                                            <button type="button" class="btn btn-success">Create Account</button>
                                        </a>
                                    </div>
    </div>
</form>
<br>


                            <div class="row">
                                <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Success - </strong> <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Error - </strong> <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>
                                
                                
                                <div class="col-12">
                                    <div class="card mt-2">
                                        <div class="card-body">
                                           
                                            <h4 class="header-title" style="margin-top:10px;">Accounts</h4>
                                            <div class="tab-content">
                                                <div class="tab-pane show active" id="basic-datatable-preview">
                                                    <table id="basic-datatable"
                                                        class="table table-striped dt-responsive nowrap w-100">
                                                        <thead>
                                                            <tr>
                                                                <th>SR</th>
                                                                <th>Date</th>
                                                                <th>Role</th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                         <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td> <!-- Display serial number starting from 1 -->
                        <td><?php echo e($user->created_at ? $user->created_at->format('Y-m-d h:i A') : 'N/A'); ?></td>

                        <td><?php echo e($user->is_admin == 1 ? 'Admin' : 'User'); ?></td>
                        <td><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td>
    <!-- Edit button -->
    <a href="<?php echo e(route('create_account.edit', $user->id)); ?>" class="btn btn-primary btn-sm">Edit</a>

    <!-- Delete button -->
    <form action="<?php echo e(route('create_account.delete', $user->id)); ?>" method="GET" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
    </form>
</td>

                        
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
                                                    </table>
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

                       
                    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/create_account/index.blade.php ENDPATH**/ ?>