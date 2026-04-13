
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Employee Registration</h4>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
               <form action="<?php echo e(route('employees.update', $employee->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="col-6">
                        
                         <div class="mb-3">
                                                <label for="joining_date" class="form-label">Joining Date</label>
                                                <input type="date" id="joining_date" class="form-control" name="joining_date"  value="<?php echo e(old('joining_date', $employee->joining_date)); ?>">
                                            </div>
                                            
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fname" class="form-label">Name</label>
                                <input type="text" id="fname" class="form-control" name="fname" value="<?php echo e(old('fname', $employee->fname)); ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lname" class="form-label">Father Name</label>
                                <input type="text" id="lname" class="form-control" name="lname"   value="<?php echo e(old('lname', $employee->lname)); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone_no" class="form-label">Phone No</label>
                                <input type="text" id="phone_no" class="form-control" name="phone_no"  value="<?php echo e(old('phone_no', $employee->phone_no)); ?>" >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="blood_group" class="form-label">Blood Group</label>
                                <input type="text" id="blood_group" class="form-control" name="blood_group"  value="<?php echo e(old('blood_group', $employee->blood_group)); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" class="form-control" name="address" value="<?php echo e(old('address', $employee->address)); ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="employee" class="form-label">Employee</label>
                                <select name="employee" class="form-control select2" data-toggle="select2" id="employee">
                                    <option value="">Select</option>
                                     <option value="offcial" <?php echo e(old('employee', $employee->employee) == 'offcial' ? 'selected' : ''); ?>>Official</option>
                                        <option value="unoffcial" <?php echo e(old('employee', $employee->employee) == 'unoffcial' ? 'selected' : ''); ?>>Unofficial</option>
                                </select>
                            </div>
                        </div>

                       
                        
                        <div class="mb-3">
    <label for="cnic_no" class="form-label">CNIC</label>
    <input type="text" id="cnic_no" class="form-control" name="cnic_no" value="<?php echo e(old('cnic_no', $employee->cnic_no)); ?>"
           maxlength="13" pattern="[0-9]{13}" 
           oninput="this.value = this.value.replace(/[^0-9]/g, '');"
           title="Please enter exactly 13 digits (numbers only)">
</div>

                        <div class="mb-3">
                            <label for="uploadFileFront" class="form-label">CNIC Front Side</label>
                            <input type="file" id="uploadFileFront" class="form-control" name="fileFront" accept="image/*">
                            <div id="filePreviewContainerFront" class="mt-2">
                                <?php if($employee->cnic_front_path): ?>
                                    <img src="<?php echo e(asset('storage/' . $employee->cnic_front_path)); ?>" alt="CNIC Front Preview" style="max-width: 150px; max-height: 150px;">
                                <?php else: ?>
                                    <div style="display:none;">
                                        <img id="imagePreviewFront" src="" alt="Image Preview" style="max-width: 150px; max-height: 150px; display:none;">
                                        <span id="fileNamePreviewFront" style="font-size:14px;"></span>
                                        <button type="button" id="removeFileFront" class="btn btn-sm btn-danger">X</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="uploadFileBack" class="form-label">CNIC Back Side</label>
                            <input type="file" id="uploadFileBack" class="form-control" name="fileBack" accept="image/*">
                            <div id="filePreviewContainerBack" class="mt-2">
                                <?php if($employee->cnic_back_path): ?>
                                    <img src="<?php echo e(asset('storage/' . $employee->cnic_back_path)); ?>" alt="CNIC Back Preview" style="max-width: 150px; max-height: 150px;">
                                <?php else: ?>
                                    <div style="display:none;">
                                        <img id="imagePreviewBack" src="" alt="Image Preview" style="max-width: 150px; max-height: 150px; display:none;">
                                        <span id="fileNamePreviewBack" style="font-size:14px;"></span>
                                        <button type="button" id="removeFileBack" class="btn btn-sm btn-danger">X</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row">
    <div class="col-md-6 mb-3">
        <label for="bonus_id" class="form-label">Bonus Type</label>
    <select name="bonus_id" id="bonus_id" class="form-control select2" data-toggle="select2">
            <option value="">Select</option>
            <?php $__currentLoopData = $extratimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extratime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($extratime->id); ?>" <?php echo e(old('bonus_id', $employee->bonus_id) == $extratime->id ? 'selected' : ''); ?>>
                <?php echo e($extratime->name); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div> 
    <div class="col-md-6 mb-3">
        <label for="rate" class="form-label">Rate</label>
        <input type="number" id="rate" class="form-control" name="rate" value="<?php echo e(old('rate', $employee->bonus_rate)); ?>">
    </div>
</div>

                        <button type="submit" class="btn btn-primary">Update Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- jQuery (must come first) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // JavaScript for file preview functionality
    document.getElementById('uploadFileFront').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const previewContainer = document.getElementById('filePreviewContainerFront');
            const imagePreview = document.getElementById('imagePreviewFront');
            const fileNamePreview = document.getElementById('fileNamePreviewFront');
            
            // Clear any existing database image
            previewContainer.innerHTML = '';
            
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    previewContainer.appendChild(imagePreview);
                };
                reader.readAsDataURL(file);
            }
            
            fileNamePreview.textContent = file.name;
            previewContainer.appendChild(fileNamePreview);
            
            const removeButton = document.getElementById('removeFileFront');
            previewContainer.appendChild(removeButton);
            
            previewContainer.style.display = 'block';
        }
    });

    document.getElementById('uploadFileBack').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const previewContainer = document.getElementById('filePreviewContainerBack');
            const imagePreview = document.getElementById('imagePreviewBack');
            const fileNamePreview = document.getElementById('fileNamePreviewBack');
            
            // Clear any existing database image
            previewContainer.innerHTML = '';
            
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    previewContainer.appendChild(imagePreview);
                };
                reader.readAsDataURL(file);
            }
            
            fileNamePreview.textContent = file.name;
            previewContainer.appendChild(fileNamePreview);
            
            const removeButton = document.getElementById('removeFileBack');
            previewContainer.appendChild(removeButton);
            
            previewContainer.style.display = 'block';
        }
    });

    // Remove file buttons
    document.getElementById('removeFileFront')?.addEventListener('click', function() {
        document.getElementById('uploadFileFront').value = '';
        document.getElementById('filePreviewContainerFront').style.display = 'none';
        document.getElementById('imagePreviewFront').src = '';
        document.getElementById('imagePreviewFront').style.display = 'none';
        document.getElementById('fileNamePreviewFront').textContent = '';
    });

    document.getElementById('removeFileBack')?.addEventListener('click', function() {
        document.getElementById('uploadFileBack').value = '';
        document.getElementById('filePreviewContainerBack').style.display = 'none';
        document.getElementById('imagePreviewBack').src = '';
        document.getElementById('imagePreviewBack').style.display = 'none';
        document.getElementById('fileNamePreviewBack').textContent = '';
    });
    
    
 
$(document).ready(function() {
    $('#bonus_id').on('change', function(e) {
        var bonusId = $(this).val();
        
        if (!bonusId) {
            $('#rate').val('');
            return;
        }
        
        $.ajax({
            url: '/probox/extra-times/' + bonusId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Assuming your response contains the rate directly or as response.rate
                if (response) {
                    $('#rate').val(response.rate || response);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });
    
    // Trigger change if there's an old value
    <?php if(old('bonus_id')): ?>
        $('#bonus_id').trigger('change');
    <?php endif; ?>
});
    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/employees/edit.blade.php ENDPATH**/ ?>