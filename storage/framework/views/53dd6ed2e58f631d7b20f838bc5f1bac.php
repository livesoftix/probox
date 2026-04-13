

<?php $__env->startSection('content'); ?>
<div class="container pt-4">

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <h2 class="mb-4">Edit Job Detail</h2>

    <form action="<?php echo e(route('packaging-specs.update', $packagingSpec->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control"
                    value="<?php echo e(old('date', ($packagingSpec->date instanceof \Illuminate\Support\Carbon) ? $packagingSpec->date->format('Y-m-d') : $packagingSpec->date)); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" class="form-control"
                       value="<?php echo e(old('company_name', $packagingSpec->company_name)); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Item Name</label>
                <input type="text" name="item_name" class="form-control"
                       value="<?php echo e(old('item_name', $packagingSpec->item_name)); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control"
                       value="<?php echo e(old('country', $packagingSpec->country)); ?>">
            </div>
        </div>

        
        <div class="row mt-4">
            <div class="col-12">
                <label class="form-label">Printing / Board / UPS</label>
                <table class="table table-bordered align-middle" id="details_table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Manual Die Size</th>
                            <th>Auto Die Size</th>
                            <th>UPS</th>
                            <th style="width: 80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $packagingSpec->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-index="<?php echo e($index); ?>">
                                <td class="row-index"><?php echo e($index + 1); ?></td>
                                <input type="hidden" name="details[<?php echo e($index); ?>][id]" value="<?php echo e($detail->id); ?>">
                                <td><input type="text" name="details[<?php echo e($index); ?>][printing_size]" class="form-control"
                                           value="<?php echo e(old("details.$index.printing_size", $detail->printing_size)); ?>" required></td>
                                <td><input type="text" name="details[<?php echo e($index); ?>][board_size]" class="form-control"
                                           value="<?php echo e(old("details.$index.board_size", $detail->board_size)); ?>" required></td>
                                <td><input type="text" name="details[<?php echo e($index); ?>][ups]" class="form-control"
                                           value="<?php echo e(old("details.$index.ups", $detail->ups)); ?>" required></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <button type="button" id="add_detail" class="btn btn-secondary btn-sm">+ Add Row</button>
            </div>
        </div>

        
        <div class="row mt-4 g-3">
            <div class="col-md-2">
                <label class="form-label">Unit</label>
                <select name="unit" class="form-control" required>
                    <option value="">Select</option>
                    <?php $__currentLoopData = ['mm','cm','inch']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($u); ?>" <?php echo e(old('unit', $packagingSpec->unit) == $u ? 'selected' : ''); ?>><?php echo e($u); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Length</label>
                <input type="text" name="length" class="form-control" value="<?php echo e(old('length', $packagingSpec->length)); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Width</label>
                <input type="text" name="width" class="form-control" value="<?php echo e(old('width', $packagingSpec->width)); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Height</label>
                <input type="text" name="height" class="form-control" value="<?php echo e(old('height', $packagingSpec->height)); ?>">
            </div>
        </div>

        <div class="row mt-3 g-3">
            <div class="col-md-6">
                <label class="form-label">Lamination Size</label>
                <input type="text" name="lam_size" class="form-control" value="<?php echo e(old('lam_size', $packagingSpec->lam_size)); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Flute Size</label>
                <input type="text" name="flute_size" class="form-control" value="<?php echo e(old('flute_size', $packagingSpec->flute_size)); ?>">
            </div>
        </div>

        
        <div class="row mt-3">
            <div class="col-md-4">
                <label class="form-label">Box Type</label>
                <?php
                    $types = ['Box board','Corrugated','Bleach Card','Craft Board','Craft paper','Art paper','VRG paper','other'];
                    $currentType = old('box_type', $packagingSpec->box_type);
                ?>
                <select name="box_type" id="box_type_select" class="form-control" required>
                    <option value="">Select Box Type</option>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type); ?>" <?php echo e($currentType == $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <div id="box_type_other_wrap" class="mt-2" style="<?php echo e($currentType == 'other' ? '' : 'display:none;'); ?>">
                    <input type="text" name="box_type_other" id="box_type_other" class="form-control"
                           placeholder="Enter custom box type"
                           value="<?php echo e(old('box_type_other', $packagingSpec->box_type_other)); ?>">
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <label class="form-label">Die pattern</label>
                <select name="die_pattern" id="Die_pattern_select" class="form-control">
                    <option value="">Select Die Pattern</option>
                    <option value="Single rule die cut" <?php echo e(old('die_pattern', $packagingSpec->die_pattern) == 'Single rule die cut' ? 'selected' : ''); ?>>Single rule die cut</option>
                    <option value="Double rule die cut" <?php echo e(old('die_pattern', $packagingSpec->die_pattern) == 'Double rule die cut' ? 'selected' : ''); ?>>Double rule die cut</option>                    
                </select>

            </div>
        </div>

        
        <h4 class="mt-4">Box Details</h4>
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Glue Flap</label>
                <input type="text" name="glue_flap" class="form-control" value="<?php echo e(old('glue_flap', $packagingSpec->glue_flap)); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Folding Flap</label>
                <input type="text" name="holding_flap" class="form-control" value="<?php echo e(old('holding_flap', $packagingSpec->holding_flap)); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Pendi</label>
                <input type="text" name="pendi" class="form-control" value="<?php echo e(old('pendi', $packagingSpec->pendi)); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Die Grip</label>
                <input type="text" name="die_grip" class="form-control" value="<?php echo e(old('die_grip', $packagingSpec->die_grip)); ?>" required>
            </div>
        </div>

        
        <div class="row mt-3 g-3">
            <div class="col-md-6">
                <label class="form-label">Designing Color</label>
                <input type="text" name="designing_color" class="form-control"
                       value="<?php echo e(old('designing_color', $packagingSpec->designing_color)); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Printing Side</label>
                <select name="printing_side" class="form-control">
                    <option value="">Select Printing Side</option>
                    <option value="Front print" <?php echo e(old('printing_side', $packagingSpec->printing_side) == 'Front print' ? 'selected' : ''); ?>>Front print</option>
                    <option value="Front back" <?php echo e(old('printing_side', $packagingSpec->printing_side) == 'Front back' ? 'selected' : ''); ?>>Front back</option>
                </select>
            </div>
        </div>

        
       
<h4 class="mt-4 mb-3">Finishing Options</h4>

<div class="finishing-wrapper">
    
    <div class="finishing-col mb-3">
        <div class="col-label fw-bold mb-2">Lamination:</div>
        <div class="d-flex flex-wrap gap-3">
            <label class="form-check-label">
                <input type="hidden" name="shine_lamination" value="0">
                <input type="checkbox" name="shine_lamination" value="1" class="form-check-input me-1"
                    <?php echo e(old('shine_lamination', $packagingSpec->shine_lamination) ? 'checked' : ''); ?>>
                Shine
            </label>
            <label class="form-check-label">
                <input type="hidden" name="matte_lamination" value="0">
                <input type="checkbox" name="matte_lamination" value="1" class="form-check-input me-1"
                    <?php echo e(old('matte_lamination', $packagingSpec->matte_lamination) ? 'checked' : ''); ?>>
                Matte
            </label>
        </div>
    </div>

    
    <div class="finishing-col mb-3">
        <div class="col-label fw-bold mb-2">UV:</div>
        <div class="d-flex flex-wrap gap-3">
            <label class="form-check-label">
                <input type="hidden" name="uv_plain" value="0">
                <input type="checkbox" name="uv_plain" value="1" class="form-check-input me-1"
                    <?php echo e(old('uv_plain', $packagingSpec->uv_plain) ? 'checked' : ''); ?>>
                Plain
            </label>
            <label class="form-check-label">
                <input type="hidden" name="uv_spot" value="0">
                <input type="checkbox" name="uv_spot" value="1" class="form-check-input me-1"
                    <?php echo e(old('uv_spot', $packagingSpec->uv_spot) ? 'checked' : ''); ?>>
                Spot
            </label>
            <label class="form-check-label">
                <input type="hidden" name="uv_drip" value="0">
                <input type="checkbox" name="uv_drip" value="1" class="form-check-input me-1"
                    <?php echo e(old('uv_drip', $packagingSpec->uv_drip) ? 'checked' : ''); ?>>
                Drip
            </label>
        </div>
    </div>

    
    <div class="finishing-col mb-3">
        <div class="col-label fw-bold mb-2">Windows:</div>
        <div class="d-flex flex-wrap gap-3">
            <label class="form-check-label">
                <input type="hidden" name="window_glass" value="0">
                <input type="checkbox" name="window_glass" value="1" class="form-check-input me-1"
                    <?php echo e(old('window_glass', $packagingSpec->window_glass) ? 'checked' : ''); ?>>
                Glass
            </label>
            <label class="form-check-label">
                <input type="hidden" name="window_lamination" value="0">
                <input type="checkbox" name="window_lamination" value="1" class="form-check-input me-1"
                    <?php echo e(old('window_lamination', $packagingSpec->window_lamination) ? 'checked' : ''); ?>>
                Lamination
            </label>
        </div>
    </div>

    
    <div class="finishing-col mb-3">
        <div class="col-label fw-bold mb-2">Finishing:</div>
        <div class="d-flex flex-wrap gap-3">
            <label class="form-check-label">
                <input type="hidden" name="emboss" value="0">
                <input type="checkbox" name="emboss" value="1" class="form-check-input me-1"
                    <?php echo e(old('emboss', $packagingSpec->emboss) ? 'checked' : ''); ?>>
                Emboss
            </label>
            <label class="form-check-label">
                <input type="hidden" name="demboss" value="0">
                <input type="checkbox" name="demboss" value="1" class="form-check-input me-1"
                    <?php echo e(old('demboss', $packagingSpec->demboss) ? 'checked' : ''); ?>>
                Deboss
            </label>
            <label class="form-check-label">
                <input type="hidden" name="gold_finish" value="0">
                <input type="checkbox" name="gold_finish" value="1" class="form-check-input me-1"
                    <?php echo e(old('gold_finish', $packagingSpec->gold_finish) ? 'checked' : ''); ?>>
                Gold Finish
            </label>
            <label class="form-check-label">
                <input type="hidden" name="silver_finish" value="0">
                <input type="checkbox" name="silver_finish" value="1" class="form-check-input me-1"
                    <?php echo e(old('silver_finish', $packagingSpec->silver_finish) ? 'checked' : ''); ?>>
                Silver Finish
            </label>
        </div>
    </div>
</div>


        
        <div class="mt-4">
            <label class="form-label">Upload Image (optional)</label>
            <input type="file" name="image_path" class="form-control">
            <?php if($packagingSpec->image_path): ?>
                <div class="mt-2">
                    <img src="<?php echo e(asset('storage/'.$packagingSpec->image_path)); ?>" alt="Preview"
                         style="max-height: 120px; border-radius: 4px;">
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="<?php echo e(route('packaging-specs.index')); ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('box_type_select');
    const otherWrap = document.getElementById('box_type_other_wrap');
    const otherInput = document.getElementById('box_type_other');

    select.addEventListener('change', function() {
        if (this.value === 'other') {
            otherWrap.style.display = 'block';
            otherInput.required = true;
        } else {
            otherWrap.style.display = 'none';
            otherInput.required = false;
            otherInput.value = '';
        }
    });

    let detailIndex = <?php echo e($packagingSpec->details->count()); ?>;
    const addBtn = document.getElementById('add_detail');
    const tableBody = document.querySelector('#details_table tbody');

    function updateRowNumbers() {
        document.querySelectorAll('#details_table tbody tr').forEach((tr, i) => {
            tr.querySelector('.row-index').textContent = i + 1;
        });
    }

    addBtn.addEventListener('click', function() {
        const row = document.createElement('tr');
        row.dataset.index = detailIndex;
        row.innerHTML = `
            <td class="row-index"></td>
            <td><input type="text" name="details[${detailIndex}][printing_size]" class="form-control" required></td>
            <td><input type="text" name="details[${detailIndex}][board_size]" class="form-control" required></td>
            <td><input type="text" name="details[${detailIndex}][ups]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
        `;
        tableBody.appendChild(row);
        updateRowNumbers();
        detailIndex++;
    });

    document.body.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            const rows = document.querySelectorAll('#details_table tbody tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                updateRowNumbers();
            } else {
                alert('At least one UPS detail is required.');
            }
        }
    });

    updateRowNumbers();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/packaging_specs/edit.blade.php ENDPATH**/ ?>