

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <!-- ❌ This will NOT be captured -->
    <div class="no-print row">
        <div class="col-12">
            <div class="d-flex justify-content-between my-3">
                <h4>Product Details</h4>

                <div>
                    <button class="btn btn-info" onclick="window.print()">Print</button>

                    <button class="btn btn-success" onclick="downloadJpg(<?php echo e($product->id); ?>)">
                        JPG Download
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ ONLY THIS WILL BE CAPTURED -->
    <div id="printable-area">

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h3 class="text-center border-bottom pb-2 mb-4">
                    Product Registration Certificate
                </h3>

                <div class="row">

                    <!-- LEFT -->
                    <div class="col-8">

                        <h5>Details</h5>

                        <table class="table table-borderless table-sm">
                            <tr>
                                <th>Product Name</th>
                                <td><?php echo e($product->prod_name); ?></td>
                            </tr>
                            <tr>
                                <th>Account</th>
                                <td><?php echo e($product->account->title ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td><?php echo e($product->product_type); ?></td>
                            </tr>
                            <tr>
                                <th>Job</th>
                                <td><?php echo e($product->job_assign); ?></td>
                            </tr>
                            <tr>
                                <th>Item</th>
                                <td><?php echo e($product->items->item_code ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th>Size</th>
                                <td><?php echo e($product->length); ?> x <?php echo e($product->width); ?></td>
                            </tr>
                            <tr>
                                <th>Grammage</th>
                                <td><?php echo e($product->grammage); ?></td>
                            </tr>
                        </table>

                    </div>

                    <!-- RIGHT IMAGE (FIXED CORS + PATH) -->
                    <div class="col-4 text-center">

                        <h5>Image</h5>

                        <div class="border p-2">

                            <?php
                                $imageUrl = $product->file_path
                                    ? 'https://real-erp.net/probox/storage/' . $product->file_path
                                    : null;

                                $base64 = null;

                                if ($imageUrl) {
                                    try {
                                        $data = @file_get_contents($imageUrl);
                                        if ($data) {
                                            $base64 = 'data:image/jpeg;base64,' . base64_encode($data);
                                        }
                                    } catch (\Exception $e) {
                                        $base64 = null;
                                    }
                                }
                            ?>

                            <?php if($base64): ?>
                                <img src="<?php echo e($base64); ?>"
                                     style="max-width:100%; max-height:280px;">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/300x250?text=No+Image">
                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <hr>

                <h5>Manufacturing Options</h5>

                <table class="table table-borderless table-sm">
                    <?php if($product->lamination): ?>
                    <tr>
                        <th>Lamination</th>
                        <td><?php echo e($product->lamItem->item_code ?? ''); ?></td>
                    </tr>
                    <?php endif; ?>

                    <?php if($product->uv): ?>
                    <tr>
                        <th>UV</th>
                        <td>Yes</td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php if($product->descr): ?>
                <hr>
                <h5>Description</h5>
                <p><?php echo e($product->descr); ?></p>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
window.onload = function () {

    const element = document.getElementById('printable-area');

    // wait a bit for images to fully render
    setTimeout(() => {

        html2canvas(element, {
            scale: 3,
            useCORS: true,
            allowTaint: true,
            backgroundColor: "#fff"
        }).then(canvas => {

            const imgData = canvas.toDataURL("image/jpeg", 1.0);

            const link = document.createElement('a');
            link.href = imgData;
            link.download = "product_<?php echo e($product->id); ?>.jpg";

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

        });

    }, 800); // IMPORTANT delay for image load

};
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/registration_form/print_download.blade.php ENDPATH**/ ?>