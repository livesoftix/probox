

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Edit Cheque Receipt</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Cheque Receipt</h4>
                </div>
            </div>
        </div>
        <!-- End page title -->

        <!-- Error Display -->
        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        
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
                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">
                                <form id="voucherForm"
                                    action="<?php echo e(route('cheque_receipts.update', $voucher->first()->v_no)); ?>"
                                    method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- Date Field -->
                                            <div class="mb-3">
                                                <label for="entryDate" class="form-label">Date</label>
                                                <input type="date" id="entryDate" class="form-control" name="date"
                                                    value="<?php echo e($voucher->first()->created_at->toDateString()); ?>">
                                            </div>

<!-- Chq Status -->
                                            <div class="mb-3">
                                                <label for="chq_status" class="form-label">Chq Status</label>
                                                <select id="chq_status" class="form-control" name="chq_status">
                                                    <option value="Pending"
                                                        <?php echo e($voucher->first()->chq_status == 'Pending' ? 'selected' : ''); ?>>
                                                        Pending</option>
                                                    <option value="Completed"
                                                        <?php echo e($voucher->first()->chq_status == 'Completed' ? 'selected' : ''); ?>>
                                                        Completed</option>
                                                    <option value="Dishonor"
                                                        <?php echo e($voucher->first()->chq_status == 'Dishonor' ? 'selected' : ''); ?>>
                                                        Dishonor</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Prepared By Field -->
                                            <div class="mb-3">
                                                <label for="prepared_by" class="form-label">Prepared By</label>
                                                <input type="text" id="prepared_by" class="form-control"
                                                    name="prepared_by" value="<?php echo e($loggedInUser->name); ?>" readonly>
                                            </div>
                                            
                                            

                                            <!-- Party Selection -->
                                            <div class="mb-3">
                                                <label for="entryParty" class="form-label">Party</label>
                                                <select name="account" class="form-control select2" id="entryParty"
                                                    data-toggle="select2">
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($account->id); ?>"
                                                            <?php echo e($voucher->first()->aid == $account->id ? 'selected' : ''); ?>>
                                                            <?php echo e($account->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="bank" class="form-label">Bank</label>
                                                <select name="bank" class="form-control select2" id="bank"
                                                    data-toggle="select2">
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($bank->id); ?>"
                                                            <?php echo e($voucher->first()->bank == $bank->id ? 'selected' : ''); ?>>
                                                            <?php echo e($bank->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            
<div class="mb-3">
                                    <label for="chq_date" class="form-label">Chq Date</label>
                                    <input type="date" id="chq_date" class="form-control" name="chq_date" value="<?php echo e($voucher->first()->chq_date); ?>">
                                </div>
                                
                                <!-- Chq No -->
                                            <div class="mb-3">
                                                <label for="chq_no" class="form-label">Chq No</label>
                                                <input type="text" id="chq_no" class="form-control" name="chq_no"
                                                    value="<?php echo e($voucher->first()->chq_no); ?>">
                                            </div>


                                            

                                            <!-- Chq Amount -->
                                            <div class="mb-3">
                                                <label for="chq_amt" class="form-label">Chq Amount</label>
                                                <input type="number" id="chq_amt" class="form-control" name="chq_amt"
                                                    value="<?php echo e($voucher->first()->chq_amt); ?>">
                                            </div>

                                             <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" class="form-control" name="description"><?php echo e($voucher->first()->description); ?></textarea>

                                </div>
                                
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End container -->
    
      <script>
    // Bank field is always enabled and required
    document.addEventListener('DOMContentLoaded', function () {
        const bankSelect = document.getElementById('bank');
        bankSelect.removeAttribute('disabled');
        bankSelect.setAttribute('required', 'required');
    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/cheque/edit.blade.php ENDPATH**/ ?>