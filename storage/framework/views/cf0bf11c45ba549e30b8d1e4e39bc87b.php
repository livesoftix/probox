
<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Form Elements</li>
                    </ol>
                </div>
                <h4 class="page-title">Register Item</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="header-title">Add Item</h2>

                    <div class="tab-content mt-2">
                        <div class="tab-pane show active" id="input-types-preview">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form action="<?php echo e(route('inventory.itemmaster')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>

                                        
                                        <div class="mb-3">
                                            <label for="item_code" class="form-label">Item Title</label>
                                            <input type="text" id="item_code" class="form-control" name="item_code"
                                                value="<?php echo e(old('item_code')); ?>" placeholder="Item Title" required>
                                            <?php $__errorArgs = ['item_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        
                                        <div class="mb-3">
                                            <label for="type_id" class="form-label">Item Type</label>
                                            <select name="type_id" id="type_id" class="form-control select2" data-toggle="select2" required>
                                                <option value="">Select</option>
                                                <?php $__currentLoopData = $itemtypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemtype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($itemtype->id); ?>"
                                                        <?php echo e(old('type_id') == $itemtype->id ? 'selected' : ''); ?>>
                                                        <?php echo e($itemtype->type_title); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        
                                        <div class="mb-3">
                                            <label for="purchase" class="form-label">Purchase</label>
                                            <input type="number" id="purchase" class="form-control" name="purchase"
                                                value="<?php echo e(old('purchase')); ?>" placeholder="Purchase" step="any">
                                            <?php $__errorArgs = ['purchase'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        
                                        <div class="mb-3">
                                            <label for="sale_rate" class="form-label">Sale Rate</label>
                                            <input type="number" id="sale_rate" class="form-control" name="sale_rate"
                                                value="<?php echo e(old('sale_rate')); ?>" placeholder="Sale Rate" step="any" >
                                            <?php $__errorArgs = ['sale_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>


                                        <div class="mb-4">
                                            <h5 class="mb-2">Select Weight Type</h5>
                                            <input type="hidden" id="weight_type" name="weight_type" value="Grammage">
                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="weight_type" id="unitGrammage" value="Grammage" checked>
                                                    <label class="form-check-label" for="unitGrammage">Grammage</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="weight_type" id="unitKG" value="KG">
                                                    <label class="form-check-label" for="unitKG">KG</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="weight_type" id="unitPound" value="Pound">
                                                    <label class="form-check-label" for="unitPound">Pound</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="weight_type" id="unitLitre" value="Litre">
                                                    <label class="form-check-label" for="unitLitre">Litre</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="weight_type" id="unitpiece" value="Piece">
                                                    <label class="form-check-label" for="unitPiece">Piece</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label id="gramageLabel" for="gramage" class="form-label">Grammage</label>
                                            <input type="number" id="gramage" class="form-control" 
                                                name="gramage" value="<?php echo e(old('gramage')); ?>" 
                                                placeholder="Grammage" step="any" required>
                                            <?php $__errorArgs = ['gramage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        
                                        <script>
                                            document.querySelectorAll('input[name="weight_type"]').forEach(radio => {
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
                            </div> <!-- end row-->
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/inventory/create_item_master.blade.php ENDPATH**/ ?>