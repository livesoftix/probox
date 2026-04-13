
<?php $__env->startSection('content'); ?>
<div class="container pt-4">
    <h1>Dashboard</h1>
    <p>Confectionary report</p>

    <!-- CDC vouchers without CBILLs section -->
    <div class="card mt-4">
        <div class="card-header bg-warning text-dark">
            <h5>CDC Vouchers Without CBILL</h5>
        </div>
        <div class="card-body">
            <?php
                // Get all CDC voucher numbers and details
                $cdcVouchers = \App\Models\ConfectioneryMaster::with('accounts')->get();
                $cbillVnos = \App\Models\ConfectBilling::pluck('old_vno')->toArray();
                $cdcWithoutCbill = $cdcVouchers->filter(function($voucher) use ($cbillVnos) {
                    return !in_array($voucher->v_no, $cbillVnos);
                });
            ?>
            <p><strong>Total CDC vouchers without CBILL:</strong> <?php echo e($cdcWithoutCbill->count()); ?></p>
            <?php if($cdcWithoutCbill->count()): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Voucher No</th>
                            <th>Date</th>
                            <th>Account</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php
    $shownVnos = [];
?>

<?php $__currentLoopData = $cdcWithoutCbill; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(!in_array($voucher->v_no, $shownVnos)): ?>
        <?php
            $shownVnos[] = $voucher->v_no;
        ?>
        <tr>
            <td><?php echo e($voucher->v_no); ?></td>
            <td><?php echo e($voucher->date ? \Carbon\Carbon::parse($voucher->date)->format('d-m-Y') : ''); ?></td>
            <td><?php echo e($voucher->accounts->title ?? 'N/A'); ?></td>
        </tr>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <p class="text-success">All PBILL vouchers have CBILLs.</p>
            <?php endif; ?>
             <?php
                // Get all CDC voucher numbers and details
                $cdcVouchers = \App\Models\DeliveryMaster::with('accounts')->get();
                $cbillVnos = \App\Models\SaleInvoice::pluck('old_vno')->toArray();
                $cdcWithoutCbill = $cdcVouchers->filter(function($voucher) use ($cbillVnos) {
                    return !in_array($voucher->v_no, $cbillVnos);
                });
            ?>
            <p><strong>Total Pharmaceutical vouchers without PBILL:</strong> <?php echo e($cdcWithoutCbill->count()); ?></p>
            <?php if($cdcWithoutCbill->count()): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Voucher No</th>
                            <th>Date</th>
                            <th>Account</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php
    $shownVnos = [];
?>

<?php $__currentLoopData = $cdcWithoutCbill; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(!in_array($voucher->v_no, $shownVnos)): ?>
        <?php
            $shownVnos[] = $voucher->v_no;
        ?>
        <tr>
            <td><?php echo e($voucher->v_no); ?></td>
            <td><?php echo e($voucher->date ? \Carbon\Carbon::parse($voucher->date)->format('d-m-Y') : ''); ?></td>
            <td><?php echo e($voucher->accounts->title ?? 'N/A'); ?></td>
        </tr>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <p class="text-success">All CDC vouchers have CBILLs.</p>
            <?php endif; ?>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/user_dashboard/user_dashboard.blade.php ENDPATH**/ ?>