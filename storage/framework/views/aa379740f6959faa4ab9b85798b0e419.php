

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h4 class="page-title">Edit Erp Param</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('erp_param.update', $erpParam->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="bankLevel" class="form-label">Bank Level</label>
            <select id="bankLevel" class="form-control" name="bank_level">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $level2s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($level2->id); ?>" <?php echo e($erpParam->bank_level == $level2->id ? 'selected' : ''); ?>>
                        <?php echo e($level2->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="cashLevel" class="form-label">Cash Level</label>
            <select id="cashLevel" class="form-control" name="cash_level">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $level2s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($level2->id); ?>" <?php echo e($erpParam->cash_level == $level2->id ? 'selected' : ''); ?>>
                        <?php echo e($level2->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="employeeLevel" class="form-label">Employee Level</label>
            <select id="employeeLevel" class="form-control" name="employee_level">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $level2s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($level2->id); ?>" <?php echo e($erpParam->employee_level == $level2->id ? 'selected' : ''); ?>>
                        <?php echo e($level2->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="employeeAdvance" class="form-label">Employee Advance</label>
            <select id="employeeAdvance" class="form-control" name="employee_advance">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $level2s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($level2->id); ?>" <?php echo e($erpParam->employee_advance == $level2->id ? 'selected' : ''); ?>>
                        <?php echo e($level2->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="supplierLevel" class="form-label">Supplier Level</label>
            <select id="supplierLevel" class="form-control" name="supplier_level">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $level2s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($level2->id); ?>" <?php echo e($erpParam->supplier_level == $level2->id ? 'selected' : ''); ?>>
                        <?php echo e($level2->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="customer_level" class="form-label">Customer Level</label>
            <select id="customer_level" class="form-control" name="customer_level">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $level2s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($level2->id); ?>" <?php echo e($erpParam->customer_level == $level2->id ? 'selected' : ''); ?>>
                        <?php echo e($level2->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="salary_level" class="form-label">Salary Level</label>
            <select id="salary_level" class="form-control" name="salary_level" data-toggle="select2">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $level2s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($level2->id); ?>" <?php echo e($erpParam->salary_level == $level2->id ? 'selected' : ''); ?>>
                    <?php echo e($level2->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="purchaseAccount" class="form-label">Purchase Account</label>
            <select id="purchaseAccount" class="form-control" name="purchase_account">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountMaster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($accountMaster->id); ?>" <?php echo e($erpParam->purchase_account == $accountMaster->id ? 'selected' : ''); ?>>
                        <?php echo e($accountMaster->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="purchaseReturnAccount" class="form-label">Purchase Return Account</label>
            <select id="purchaseReturnAccount" class="form-control" name="purchase_return_account">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountMaster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($accountMaster->id); ?>" <?php echo e($erpParam->purchase_return_account == $accountMaster->id ? 'selected' : ''); ?>>
                        <?php echo e($accountMaster->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="saleAc" class="form-label">Sale Account</label>
            <select id="saleAc" class="form-control" name="sale_ac">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountMaster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($accountMaster->id); ?>" <?php echo e($erpParam->sale_ac == $accountMaster->id ? 'selected' : ''); ?>>
                        <?php echo e($accountMaster->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="cashAccount" class="form-label">Cash Account</label>
            <select id="cashAccount" class="form-control" name="cash_acc">
                <option value="">Select Account</option>
               <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountMaster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($accountMaster->id); ?>" <?php echo e($erpParam->cash_acc == $accountMaster->id ? 'selected' : ''); ?>>
        <?php echo e($accountMaster->title); ?>

    </option>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="pur_freight" class="form-label">Purchase Freight</label>
            <select id="pur_freight" class="form-control" name="pur_freight">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountMaster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($accountMaster->id); ?>" <?php echo e($erpParam->pur_freight == $accountMaster->id ? 'selected' : ''); ?>>
                        <?php echo e($accountMaster->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="pur_freight_exp" class="form-label">Purchase Freight Expense</label>
            <select id="pur_freight_exp" class="form-control" name="pur_freight_exp">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountMaster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($accountMaster->id); ?>" <?php echo e($erpParam->pur_freight_exp == $accountMaster->id ? 'selected' : ''); ?>>
                        <?php echo e($accountMaster->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="sale_freight" class="form-label">Sale Freight</label>
            <select id="sale_freight" class="form-control" name="sale_freight">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountMaster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($accountMaster->id); ?>" <?php echo e($erpParam->sale_freight == $accountMaster->id ? 'selected' : ''); ?>>
                        <?php echo e($accountMaster->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="sale_freight_exp" class="form-label">Sale Freight Expense</label>
            <select id="sale_freight_exp" class="form-control" name="sale_freight_exp">
                <option value="">Select Account</option>
                <?php $__currentLoopData = $accountMasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accountMaster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($accountMaster->id); ?>" <?php echo e($erpParam->sale_freight_exp == $accountMaster->id ? 'selected' : ''); ?>>
                        <?php echo e($accountMaster->title); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
</div>
                        
                        
                        


                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Include jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function() {
        
        $('#bankLevel').select2({
            width: '100%'
        });
        $('#cashLevel').select2({
            width: '100%'
        });
         $('#employeeLevel').select2({
            width: '100%'
        });
        $('#salary_level').select2({
            width: '100%'
        });
        $('#supplierLevel').select2({
            width: '100%'
        });
        $('#purchaseAccount').select2({
            width: '100%'
        });
        $('#purchaseReturnAccount').select2({
            width: '100%'
        });
        $('#saleAc').select2({
            width: '100%'
        });
        $('#employeeAdvance').select2({
            width: '100%'
        });
        $('#customer_advance').select2({
            width: '100%'
        });
        $('#pur_freight').select2({
            width: '100%'
        });
        $('#pur_freight_exp').select2({
            width: '100%'
        });
        $('#sale_freight').select2({
            width: '100%'
        });
        $('#sale_freight_exp').select2({
            width: '100%'
        });
        $('#cashAccount').select2({
            width: '100%'
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/erp_params/edit.blade.php ENDPATH**/ ?>