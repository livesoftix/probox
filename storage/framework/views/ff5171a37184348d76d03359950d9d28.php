
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Form Elements</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Registered Item</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">


                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form action="<?php echo e(route('inventory.itemmaster.update', $itemMasters->id)); ?>"
                                            method="POST">
                                            <?php echo csrf_field(); ?>

                                            <div class="mb-3">
                                                <label for="item_code" class="form-label">Title</label>
                                                <input type="text" id="item_code" class="form-control" name="item_code"
                                                    value="<?php echo e(old('item_code', $itemMasters->item_code)); ?>" required>

                                                <!-- Display validation error for 'item_code' -->
                                                <?php if($errors->has('item_code')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('item_code')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="mb-3">
                                                <label for="type_id" class="form-label">Item Type</label>
                                                <select name="type_id" id="type_id" class="form-control select2"
                                                    data-toggle="select2" required>
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $itemtypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemtype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($itemtype->id); ?>"
                                                            <?php echo e(old('type_id', $itemMasters->type_id) == $itemtype->id ? 'selected' : ''); ?>>
                                                            <?php echo e($itemtype->type_title); ?>

                                                            <!-- Display the type title instead of type_id -->
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                                <!-- Display validation error for 'type_id' -->
                                                <?php if($errors->has('type_id')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('type_id')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="mb-3">
                                                <label for="purchase" class="form-label">Purchase</label>
                                                <input type="number" id="purchase" class="form-control" name="purchase"
                                                    value="<?php echo e(old('purchase', $itemMasters->purchase)); ?>"  step="any">

                                                <!-- Display validation error for 'purchase' -->
                                                <?php if($errors->has('purchase')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('purchase')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="mb-3">
                                                <label for="sale_rate" class="form-label">Sale Rate</label>
                                                <input type="number" id="sale_rate" class="form-control" name="sale_rate"
                                                    value="<?php echo e(old('sale_rate', $itemMasters->sale_rate)); ?>" step="any">

                                                <!-- Display validation error for 'sale_rate' -->
                                                <?php if($errors->has('sale_rate')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('sale_rate')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="mb-4">
                                                <h5 class="mb-2">Select Weight Type</h5>
                                                <input type="hidden" id="weight_type" name="weight_type" value="<?php echo e(old('weight_type', $itemMasters->weight_type ?? 'Grammage')); ?>">
                                                <div class="d-flex flex-wrap gap-2 mb-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="weight_type" id="unitGrammage" value="Grammage" <?php echo e((old('weight_type', $itemMasters->weight_type ?? 'Grammage') == 'Grammage') ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="unitGrammage">Grammage</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="weight_type" id="unitKG" value="KG" <?php echo e((old('weight_type', $itemMasters->weight_type ?? '') == 'KG') ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="unitKG">KG</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="weight_type" id="unitPound" value="Pound" <?php echo e((old('weight_type', $itemMasters->weight_type ?? '') == 'Pound') ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="unitPound">Pound</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="weight_type" id="unitLitre" value="Litre" <?php echo e((old('weight_type', $itemMasters->weight_type ?? '') == 'Litre') ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="unitLitre">Litre</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label id="gramageLabel" for="gramage" class="form-label"><?php echo e(old('weight_type', $itemMasters->weight_type ?? 'Grammage')); ?></label>
                                                <input type="number" id="gramage" class="form-control" name="gramage"
                                                    value="<?php echo e(old('gramage', $itemMasters->gramage)); ?>" required step="any" placeholder="<?php echo e(old('weight_type', $itemMasters->weight_type ?? 'Grammage')); ?>">
                                                <?php if($errors->has('gramage')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('gramage')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <script>
                                                document.querySelectorAll('input[name="weight_type"]').forEach(function(radio) {
                                                    radio.addEventListener('change', function() {
                                                        document.getElementById('gramageLabel').textContent = this.value;
                                                        document.getElementById('gramage').placeholder = this.value;
                                                        document.getElementById('weight_type').value = this.value;
                                                    });
                                                });
                                            </script>

                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>

                                    </div> <!-- end col -->


                                </div>
                                <!-- end row-->
                            </div> <!-- end preview-->


                        </div> <!-- end tab-content-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->



    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/inventory/edit_item_master.blade.php ENDPATH**/ ?>