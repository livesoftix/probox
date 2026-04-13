

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Cheque Receipts</h4>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="voucherForm" action="<?php echo e(route('cheque_receipts.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-6">

                            
                            <div class="mb-3">
                                <label for="entryDate" class="form-label">Date</label>
                                <input type="date" id="entryDate" class="form-control" name="date">
                            </div>

                            
                            <div class="mb-3">
                                <label for="chq_status" class="form-label">Cheque Status</label>
                                <select id="chq_status" class="form-control" name="chq_status">
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Dishonor">Dishonor</option>
                                </select>
                            </div>

                            
                            <div class="mb-3">
                                <label for="preparedBy" class="form-label">Prepared By</label>
                                <input type="text" id="preparedBy" class="form-control" name="prepared_by"
                                    value="<?php echo e($loggedInUser->name); ?>" readonly>
                            </div>

                            
                            <div class="mb-3">
                                <label for="entryParty" class="form-label">Party</label>
                                <select name="account" class="form-control select2" id="entryParty" data-toggle="select2" required>
                                    <option value="">Select</option>
                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($account->id); ?>"><?php echo e($account->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div class="mb-3">
                                <label for="bank" class="form-label">Bank</label>
                                <select name="bank" class="form-control select2" id="bank" data-toggle="select2">
                                    <option value="">Select</option>
                                    <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div class="mb-3">
                                <label for="chq_date" class="form-label">Cheque Date</label>
                                <input type="date" id="chq_date" class="form-control" name="chq_date">
                            </div>

                            
                            <div class="mb-3">
                                <label for="chq_no" class="form-label">Cheque No</label>
                                <input type="text" id="chq_no" class="form-control" name="chq_no">
                            </div>

                            
                            <div class="mb-3">
                                <label for="chq_amt" class="form-label">Cheque Amount</label>
                                <input type="number" id="chq_amt" class="form-control" name="chq_amt" step="0.01">
                            </div>

                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" class="form-control" name="description" rows="3"></textarea>
                            </div>

                            <button type="submit" id="addEntry" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const chqStatus = document.getElementById('chq_status');
    const bankSelect = document.getElementById('bank');

    function toggleBankRequirement() {
        // Keep the bank enabled but not required
        bankSelect.removeAttribute('disabled');
        bankSelect.removeAttribute('required');
    }

    toggleBankRequirement();
    chqStatus.addEventListener('change', toggleBankRequirement);

    // Auto-fill current date
    document.getElementById('entryDate').valueAsDate = new Date();
});
</script>
<?php $__env->stopSection(); ?>
 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/cheque/index.blade.php ENDPATH**/ ?>