<div class="modal fade" id="freezeModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content shadow-lg border-0 rounded-3">

            <form action="<?php echo e(route('product-freezing.store')); ?>" method="POST">

                <?php echo csrf_field(); ?>

                <!-- Header -->
                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title fw-bold">

                        <i class="bi bi-snow me-2"></i>

                        Product Freezing Slip

                    </h5>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- Body -->
                <div class="modal-body">

                    <div class="row">

                        <!-- Slip No -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-semibold">

                                Slip No <span class="text-danger">*</span>

                            </label>
<?php
$slipNo = 'PF-' . str_pad((\App\Models\ProductFreezing::max('id') ?? 0) + 1, 5, '0', STR_PAD_LEFT);
?>
                            <input type="text"
                                   class="form-control"
                                   name="slip_no"
                                   value="<?php echo e($slipNo); ?>"
                                   readonly>

                        </div>

                        <!-- Date -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-semibold">

                                Date <span class="text-danger">*</span>

                            </label>

                            <input type="date"
                                   name="date"
                                   class="form-control"
                                   value="<?php echo e(date('Y-m-d')); ?>"
                                   required>

                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-semibold">

                                Status

                            </label>

                            <input type="text"
                                   id="status"
                                   class="form-control"
                                   value="Inactive"
                                   readonly>

                        </div>

                        <!-- Product -->
                        <div class="col-md-12 mb-3">

                            <label class="form-label fw-semibold">

                                Product Name <span class="text-danger">*</span>

                            </label>

                            <select name="product_id"
                                    id="product_id"
                                    class="form-control select2" data-toggle="select2"
                                    required>

                                <option value="">Select Product</option>

                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option value="<?php echo e($product->id); ?>"
                                            data-status="<?php echo e($product->status); ?>">

                                        <?php echo e($product->prod_name); ?>


                                    </option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>

                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">

                            <label class="form-label fw-semibold">

                                Description

                            </label>

                            <textarea name="description"
                                      rows="4"
                                      class="form-control"
                                      placeholder="Enter detailed description..."></textarea>

                        </div>

                    </div>

                    <!-- Authorization -->

                    <div class="mt-3">

                        <h6 class="text-primary fw-bold">

                            <i class="bi bi-person-check me-1"></i>

                            Authorization

                        </h6>

                        <hr>

                    </div>

                    <div class="row">

                        <!-- Prepared By -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Prepared By

                            </label>

                            <input type="text"
                                   name="prepared_by"
                                   class="form-control"
                                   placeholder="Full name">

                        </div>

                        <!-- Production By -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Production By

                            </label>

                            <input type="text"
                                   name="production_by"
                                   class="form-control"
                                   placeholder="Production manager or representative">

                        </div>

                    </div>

                </div>

                <!-- Footer -->

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        <i class="bi bi-x-lg me-1"></i>

                        Cancel

                    </button>

                    <button type="reset"
                            class="btn btn-light border">

                        <i class="bi bi-arrow-clockwise me-1"></i>

                        Reset

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-save me-1"></i>

                        Save Slip

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- Select2 -->
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function () {

    $('#product_id').select2({

        dropdownParent: $('#freezeModal'),
        width: '100%'

    });

    $('#product_id').change(function () {

        let status = $(this).find(':selected').data('status');

        if (status === 'active') {

            $('#status').val('inactive');

        } else {

            $('#status').val(status ?? '');

        }

    });
    $('#freezeModal').on('shown.bs.modal', function () {

    $('#product_id').select2({
        dropdownParent: $('#freezeModal'),
        width: '100%'
    });

});

});
</script><?php /**PATH C:\laragon\www\probox\resources\views/product_freezing/modal.blade.php ENDPATH**/ ?>