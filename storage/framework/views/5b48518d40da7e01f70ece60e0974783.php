

<?php $__env->startSection('content'); ?>
<div class="container pt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Job Detail</h2>
        <a href="<?php echo e(route('packaging-specs.create')); ?>" class="btn btn-success">
            <i class="fa fa-plus"></i> New Entry
        </a>
    </div>

    
    <div class="card shadow-sm mb-3">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control form-control-sm"
                           value="<?php echo e(request('date')); ?>" placeholder="Date">
                </div>
                <div class="col-md-3">
                    <input type="text" name="company_name" class="form-control form-control-sm"
                           value="<?php echo e(request('company_name')); ?>" placeholder="Company Name">
                </div>
                <div class="col-md-3">
                    <input type="text" name="item_name" class="form-control form-control-sm"
                           value="<?php echo e(request('item_name')); ?>" placeholder="Item Name">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i class="fa fa-search"></i> Filter
                    </button>
                    <a href="<?php echo e(route('packaging-specs.index')); ?>" class="btn btn-outline-dark btn-sm">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    
    <div class="table-responsive">
        <table class="table table-sm table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Company</th>
                    <th>Item</th>
                    <th class="text-center" style="width: 140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $specs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e(\Carbon\Carbon::parse($spec->date)->format('d-m-Y')); ?></td>
                        <td><?php echo e($spec->company_name); ?></td>
                        <td><?php echo e($spec->item_name); ?></td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1 justify-content-center flex-nowrap">
                                <a href="<?php echo e(route('packaging-specs.show', $spec)); ?>" 
                                   class="btn btn-icon btn-light btn-sm" title="View">
                                    <i class="uil uil-eye text-primary"></i>
                                </a>
                                <a href="<?php echo e(route('packaging-specs.edit', $spec)); ?>" 
                                   class="btn btn-icon btn-light btn-sm" title="Edit">
                                    <i class="uil uil-edit text-warning"></i>
                                </a>
                                <a href="<?php echo e(route('packaging-specs.print', $spec)); ?>" 
                                   class="btn btn-icon btn-light btn-sm" title="Print" target="_blank">
                                    <i class="uil uil-print text-success"></i>
                                </a>
                                <form action="<?php echo e(route('packaging-specs.destroy', $spec)); ?>" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this packaging spec?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-icon btn-light btn-sm" title="Delete">
                                        <i class="uil uil-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No packaging specs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

   
    
</div>


<?php $__env->startPush('styles'); ?>
<style>
    .btn-icon {
        padding: 2px 5px;
        line-height: 1;
        font-size: 0.8rem;
        border-radius: 6px;
    }

    .btn-icon i {
        font-size: 14px;
        vertical-align: middle;
    }

    .btn-icon:hover {
        background-color: #f1f1f1;
    }

    th, td {
        vertical-align: middle !important;
    }

    .table th {
        white-space: nowrap;
    }

    .table td {
        white-space: nowrap;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/packaging_specs/index.blade.php ENDPATH**/ ?>