

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Job Sheet List</h4>
            </div>
        </div>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div class="card mt-2">
        <div class="card-body">

            <form action="<?php echo e(route('tempjob.report')); ?>" method="GET">
                <div class="row">

                    
                    <div class="col-md-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                               value="<?php echo e(request('start_date')); ?>">
                    </div>

                    
                    <div class="col-md-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control"
                               value="<?php echo e(request('end_date')); ?>">
                    </div>

                    
                    <div class="col-md-3">
                        <label>TJS No</label>
                        <select name="v_no" class="form-control select2">
                            <option value="">All</option>
                            <?php $__currentLoopData = $vNos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vNo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($vNo); ?>" <?php echo e(request('v_no') == $vNo ? 'selected' : ''); ?>>
                                    TJS-<?php echo e($vNo); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div class="col-md-3" style="display:none">
                        <label>Party</label>
                        <select name="account_id" class="form-control select2">
                            <option value="">All</option>
                            <?php $__currentLoopData = $accountIds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(request('account_id') == $id ? 'selected' : ''); ?>>
                                    <?php echo e($title); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                     

                      <div class="col-md-3">
                        <label>Job</label>
                        <select name="job_id" id="job_id" class="form-control select2">
                            <option value="">All</option>
                          
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($title->id); ?>" <?php echo e(request('job_id') == $title->id ? 'selected' : ''); ?>>
                                    <?php echo e($title->prod_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>


                    
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="<?php echo e(route('tempjob.list')); ?>" class="btn btn-success">Add New</a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    
    <div class="card mt-2">
        <div class="card-body">

            <button class="btn btn-secondary mb-2" onclick="printTable()">Print</button>

            <div id="print-area" class="table-responsive">

                <table class="table table-bordered table-striped w-100">

                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>V No</th>
                            <th>Job Name</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <!-- <th>Party</th> -->
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $generalJobSheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($job->date); ?></td>
                                <td>TJS-<?php echo e($job->v_no); ?></td>
                                <td><?php echo e($job->product?->prod_name); ?></td>
                                <td><?php echo e($job->size); ?></td>
                                <td><?php echo e($job->qty); ?></td>
                                <!-- <td><?php echo e($job->account->title ?? 'N/A'); ?></td> -->
                                <td><?php echo e($job->note); ?></td>

                                <td>
                                    <form action="<?php echo e(route('tempjob.destroy', $job->id)); ?>"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <a href="<?php echo e(route('tempjob.print', $job->id)); ?>"
       target="_blank"
       class="btn btn-warning btn-sm">
        View
    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center">No records found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
      $(document).ready(function () {
    $('#job_id').select2({
        placeholder: 'Select Job',
        allowClear: true,
        width: '100%'
    });
});

function printTable() {
    const printContents = document.getElementById('print-area').innerHTML;

    const w = window.open('', '', 'width=900,height=700');

    w.document.write(`
        <html>
        <head>
            <title>Print Job Sheet</title>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                }
                th {
                    background: #eee;
                }
            </style>
        </head>
        <body>
            ${printContents}
        </body>
        </html>
    `);

    w.document.close();
    w.print();
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/temp_job_sheet/index.blade.php ENDPATH**/ ?>