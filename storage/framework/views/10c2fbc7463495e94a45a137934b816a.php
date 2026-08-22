

<?php $__env->startSection('content'); ?>

<style>
.a4-sheet {
    width: 280mm;
    min-height: 297mm;
    margin: auto;
    background: #fff;
    padding: 12mm;
    box-shadow: 0 0 10px rgba(0,0,0,.15);
}

@media print {
    .a4-sheet {
        width: 210mm;
        min-height: 297mm;
        box-shadow: none;
        padding: 10mm;
    }
}
</style>

<div class="container-fluid">

    <div class="card">
        <div class="card-body">

            <div class="a4-sheet">

                <form action="<?php echo e(route('tempjob.update', $job->id)); ?>" method="POST">

                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row">

                        
                        <div class="col-md-4 mb-3">
                            <label>Date</label>
                            <input
                                type="date"
                                name="date"
                                class="form-control"
                                value="<?php echo e(old('date', $job->date ? \Carbon\Carbon::parse($job->date)->format('Y-m-d') : '')); ?>"
                            >
                        </div>


                        
                        <div class="col-md-4 mb-3">
                            <label>Prepared By</label>

                            <input
                                type="text"
                                class="form-control"
                                name="preparedby"
                                value="<?php echo e(old('preparedby', $job->preparedby ?? $loggedInUser->name)); ?>"
                                readonly
                            >
                        </div>


                        
                        <div class="col-md-4 mb-3">
                            <label>Job No</label>

                            <input
                                type="text"
                                name="job_no"
                                class="form-control"
                                value="<?php echo e(old('job_no', $job->v_no)); ?>"
                            >
                        </div>


                        
                        <div class="col-md-12 mb-3">
                            <label>Job Name</label>

                            <select
                                name="job_id"
                                id="job_id"
                                class="form-control select2"
                            >
                                <option value="">Select Job</option>

                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option
                                        value="<?php echo e($product->id); ?>"
                                        <?php echo e(old('job_id', $job->job_id) == $product->id ? 'selected' : ''); ?>

                                    >
                                        <?php echo e($product->prod_name); ?>

                                    </option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>


                        
                        <div class="col-md-6 mb-3">

                            <label>Printing For</label>

                            <select
                                name="printing_for"
                                id="printing_for"
                                class="form-control"
                            >
                                <option value="">Select</option>

                                <option
                                    value="Proofing"
                                    <?php echo e(old('printing_for', $job->printing_for) == 'Proofing' ? 'selected' : ''); ?>

                                >
                                    Proofing
                                </option>

                                <option
                                    value="Job Production"
                                    <?php echo e(old('printing_for', $job->printing_for) == 'Job Production' ? 'selected' : ''); ?>

                                >
                                    Job Production
                                </option>

                            </select>

                        </div>


                        
                        <div class="col-md-6 mb-3">
                            <label>Size</label>

                            <input
                                type="text"
                                name="size"
                                class="form-control"
                                value="<?php echo e(old('size', $job->size)); ?>"
                            >
                        </div>


                        
                        <div class="col-md-6 mb-3">
                            <label>Ups</label>

                            <input
                                type="number"
                                name="ups"
                                id="ups"
                                class="form-control"
                                value="<?php echo e(old('ups', $job->ups)); ?>"
                            >
                        </div>


                        
                        <div class="col-md-6 mb-3">
                            <label>Qty Of Boxes</label>

                            <input
                                type="number"
                                name="qty"
                                id="qty_boxes"
                                class="form-control"
                                value="<?php echo e(old('qty', $job->qty)); ?>"
                            >
                        </div>


                        
                        <div class="col-md-6 mb-3">
                            <label>P.Size</label>

                            <input
                                type="text"
                                name="p_size"
                                id="p_size"
                                class="form-control"
                                value="<?php echo e(old('p_size', $job->p_size)); ?>"
                            >
                        </div>


                        
                        <div class="col-md-6 mb-3" style="display:none">
                            <label>No Of Used Rims / Pkt</label>

                            <input
                                type="text"
                                name="ream_pkt"
                                class="form-control"
                                value="<?php echo e(old('ream_pkt', $job->ream_packet)); ?>"
                            >
                        </div>


                        
                        <div class="col-12">

                            <hr>

                            <h5>Boxboard Details</h5>

                        </div>


                        <div class="col-12">

                            <div id="boxboard-wrapper">

                                <?php if($job->boxboards->count() > 0): ?>

                                    <?php $__currentLoopData = $job->boxboards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $box): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php
                                            $boxValue =
                                                $box->item_id . '_' .
                                                $box->width . '_' .
                                                $box->length . '_' .
                                                $box->grammage;
                                        ?>

                                        <div class="row item-row mb-3">

                                            
                                            <div class="col-md-5">

                                                <label>Item</label>

                                                <select
                                                    class="form-control item-selection"
                                                    name="box_item[]"
                                                >

                                                    <option value="">Select Item</option>

                                                    <?php $__currentLoopData = $boxboardData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option
                                                            value="<?php echo e($item->item_id); ?>_<?php echo e($item->width); ?>_<?php echo e($item->length); ?>_<?php echo e($item->grammage); ?>"
                                                            data-stock="<?php echo e($item->remain_qty); ?>"
                                                            data-itemid="<?php echo e($item->item_id); ?>"
                                                            <?php echo e($boxValue == ($item->item_id . '_' . $item->width . '_' . $item->length .'_' . $item->grammage) ? 'selected' : ''); ?>

                                                        >
                                                            <?php echo e($item->item_code); ?>

                                                            (L:<?php echo e($item->length); ?> x W:<?php echo e($item->width); ?>)
                                                        </option>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </select>

                                                <input
                                                    type="hidden"
                                                    name="purchase_vno[]"
                                                    class="purchase-vno"
                                                    value="<?php echo e($box->purchase_v_no); ?>"
                                                >

                                            </div>


                                            
                                            <div class="col-md-3">

                                                <label>Length</label>

                                                <input
                                                    type="text"
                                                    class="form-control box-length"
                                                    name="box_length[]"
                                                    value="<?php echo e($box->length); ?>"
                                                    readonly
                                                >

                                            </div>


                                            
                                            <div class="col-md-3">

                                                <label>Width</label>

                                                <input
                                                    type="text"
                                                    class="form-control box-width"
                                                    name="box_width[]"
                                                    value="<?php echo e($box->width); ?>"
                                                    readonly
                                                >

                                            </div>
  
                                            <div class="col-md-3">

                                                <label>Grammage</label>

                                                <input
                                                    type="text"
                                                    class="form-control box-grammage"
                                                    name="box_grammage[]"
                                                    value="<?php echo e($box->grammage); ?>"
                                                    readonly
                                                >

                                            </div>

                                            
                                            <div class="col-md-3">

                                                <label>T.Stock</label>

                                                <input
                                                    type="number"
                                                    class="form-control total-stock"
                                                    value=""
                                                    readonly
                                                >

                                            </div>


                                            
                                            <div class="col-md-3">

                                                <label>No Of Used Rims / Pkt</label>

                                                <input
                                                    type="number"
                                                    class="form-control box-stock"
                                                    name="box_qty[]"
                                                    value="<?php echo e($box->qty); ?>"
                                                    step="any"
                                                >

                                            </div>


                                            
                                            <div class="col-md-3">

                                                <label>After Cutting</label>

                                                <select
                                                    name="after_cutting[]"
                                                    class="form-control select2 after-cutting"
                                                >

                                                    <option value="">Select</option>

                                                    <?php for($i = 1; $i <= 4; $i++): ?>

                                                        <option
                                                            value="<?php echo e($i); ?>"
                                                            <?php echo e($box->after_cutting == $i ? 'selected' : ''); ?>

                                                        >
                                                            <?php echo e($i); ?>

                                                        </option>

                                                    <?php endfor; ?>

                                                </select>

                                            </div>


                                            
                                            <div class="col-md-3">

                                                <label>Remaining Stock</label>

                                                <input
                                                    type="number"
                                                    class="form-control box-total-stock"
                                                    readonly
                                                >

                                            </div>


                                            
                                            <div class="col-md-2 d-flex align-items-end gap-2 mt-2">

                                                <button
                                                    type="button"
                                                    class="btn btn-success add-row"
                                                >
                                                    +
                                                </button>

                                                <button
                                                    type="button"
                                                    class="btn btn-danger remove-row"
                                                >
                                                    ×
                                                </button>

                                            </div>

                                        </div>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php else: ?>

                                    
                                    <div class="row item-row mb-3">

                                        <div class="col-md-5">

                                            <label>Item</label>

                                            <select
                                                class="form-control item-selection"
                                                name="box_item[]"
                                            >

                                                <option value="">Select Item</option>

                                                <?php $__currentLoopData = $boxboardData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option
                                                        value="<?php echo e($item->item_id); ?>_<?php echo e($item->width); ?>_<?php echo e($item->length); ?>_<?php echo e($item->grammage); ?>"
                                                        data-stock="<?php echo e($item->remain_qty); ?>"
                                                        data-itemid="<?php echo e($item->item_id); ?>" >
                                                        <?php echo e($item->item_code); ?>

                                                        (L:<?php echo e($item->length); ?> x W:<?php echo e($item->width); ?>)
                                                    </option>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </select>

                                            <input
                                                type="hidden"
                                                name="purchase_vno[]"
                                                class="purchase-vno"
                                            >

                                        </div>


                                        <div class="col-md-3">

                                            <label>Length</label>

                                            <input
                                                type="text"
                                                class="form-control box-length"
                                                name="box_length[]"
                                                readonly
                                            >

                                        </div>


                                        <div class="col-md-3">

                                            <label>Width</label>

                                            <input
                                                type="text"
                                                class="form-control box-width"
                                                name="box_width[]"
                                                readonly
                                            >

                                        </div>
  
                                            <div class="col-md-3">

                                                <label>Grammage</label>

                                                <input
                                                    type="text"
                                                    class="form-control box-grammage"
                                                    name="box_grammage[]"
                                                    readonly
                                                >

                                            </div>

                                        <div class="col-md-3">

                                            <label>T.Stock</label>

                                            <input
                                                type="number"
                                                class="form-control total-stock"
                                                readonly
                                            >

                                        </div>


                                        <div class="col-md-3">

                                            <label>No Of Used Rims / Pkt</label>

                                            <input
                                                type="number"
                                                class="form-control box-stock"
                                                name="box_qty[]"
                                                step="any"
                                            >

                                        </div>


                                        <div class="col-md-3">

                                            <label>After Cutting</label>

                                            <select
                                                name="after_cutting[]"
                                                class="form-control select2 after-cutting"
                                            >

                                                <option value="">Select</option>

                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>

                                            </select>

                                        </div>


                                        <div class="col-md-3">

                                            <label>Remaining Stock</label>

                                            <input
                                                type="number"
                                                class="form-control box-total-stock"
                                                readonly
                                            >

                                        </div>


                                        <div class="col-md-2 d-flex align-items-end gap-2 mt-2">

                                            <button
                                                type="button"
                                                class="btn btn-success add-row"
                                            >
                                                +
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-danger remove-row"
                                            >
                                                ×
                                            </button>

                                        </div>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>


                        
                        <div class="col-12">

                            <hr>

                            <h5>Process Details</h5>

                        </div>


                        
                        <div class="col-md-12">

                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="lamination"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="lamination"
                                    name="lamination"
                                    value="1"
                                    <?php echo e(old('lamination', $job->lamination) == 1 ? 'checked' : ''); ?>

                                >

                                <label class="form-check-label">
                                    Lamination
                                </label>

                            </div>


                            <div
                                id="laminationFields"
                                style="<?php echo e($job->lamination == 1 ? 'display:block;' : 'display:none;'); ?>"
                            >

                                <div class="row mt-3">

                                    <div class="col-md-4">

                                        <label>Size</label>

                                        <input
                                            type="number"
                                            class="form-control"
                                            id="lsize"
                                            name="lsize"
                                            step="any"
                                            value="<?php echo e($job->lam_size); ?>"
                                        >

                                    </div>


                                    <div class="col-md-8">

                                        <label>Item Type</label>

                                        <select
                                            name="litem"
                                            id="litem"
                                            class="form-control select2"
                                        >

                                            <option value="">Select Item</option>

                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option
                                                    value="<?php echo e($item->id); ?>"
                                                    <?php echo e($job->lam_item == $item->id ? 'selected' : ''); ?>

                                                >
                                                    <?php echo e($item->item_code); ?>

                                                </option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>

                                    </div>

                                </div>

                            </div>


                            
                            <div class="form-check mt-3">

                                <input
                                    type="hidden"
                                    name="uv"
                                    value="0"
                                >

                                <input
                                    type="checkbox"
                                    name="uv"
                                    id="uv"
                                    value="1"
                                    <?php echo e($job->uv == 1 ? 'checked' : ''); ?>

                                >

                                <label class="form-check-label">
                                    UV
                                </label>

                            </div>


                            <div
                                id="uvFields"
                                style="<?php echo e($job->uv == 1 ? 'display:block' : 'display:none'); ?>"
                            >

                                <div class="row">

                                    <div class="col-md-2 mb-3">

                                        <div class="form-check">

                                            <input
                                                type="hidden"
                                                name="simple"
                                                value="0"
                                            >

                                            <input
                                                type="checkbox"
                                                name="simple"
                                                id="simple"
                                                value="1"
                                                <?php echo e($job->simple == 1 ? 'checked' : ''); ?>

                                            >

                                            <label>Simple</label>

                                        </div>

                                    </div>


                                    <div class="col-md-2 mb-3">

                                        <div class="form-check">

                                            <input
                                                type="hidden"
                                                name="spot"
                                                value="0"
                                            >

                                            <input
                                                type="checkbox"
                                                name="spot"
                                                id="spot"
                                                value="1"
                                                <?php echo e($job->spot == 1 ? 'checked' : ''); ?>

                                            >

                                            <label>Spot</label>

                                        </div>

                                    </div>


                                    <div class="col-md-2 mb-3">

                                        <div class="form-check">

                                            <input
                                                type="hidden"
                                                name="tripof"
                                                value="0"
                                            >

                                            <input
                                                type="checkbox"
                                                name="tripof"
                                                id="tripof"
                                                value="1"
                                                <?php echo e($job->tripof == 1 ? 'checked' : ''); ?>

                                            >

                                            <label>Trip Of</label>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            
                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="corrugation"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="corrugation"
                                    name="corrugation"
                                    value="1"
                                    <?php echo e($job->corrugation == 1 ? 'checked' : ''); ?>

                                >

                                <label class="form-check-label">
                                    Corrugation
                                </label>

                            </div>


                            <div
                                id="corrugationFields"
                                style="<?php echo e($job->corrugation == 1 ? 'display:block;' : 'display:none;'); ?>"
                            >

                                <div class="row mt-3">

                                    <div class="col-md-4">

                                        <label>Size</label>

                                        <input
                                            type="number"
                                            class="form-control"
                                            id="csize"
                                            name="csize"
                                            step="any"
                                            value="<?php echo e($job->curr_size); ?>"
                                        >

                                    </div>


                                    <div class="col-md-8">

                                        <label>Item Type</label>

                                        <select
                                            name="citem"
                                            id="citem"
                                            class="form-control select2"
                                        >

                                            <option value="">Select Item</option>

                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <?php if($item->type_id == 2): ?>

                                                    <option
                                                        value="<?php echo e($item->id); ?>"
                                                        <?php echo e($job->curr_item == $item->id ? 'selected' : ''); ?>

                                                    >
                                                        <?php echo e($item->item_code); ?>

                                                    </option>

                                                <?php endif; ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>

                                    </div>

                                </div>

                            </div>


                            
                            <div class="col-md-3 form-check mt-3">

                                <input
                                    type="hidden"
                                    name="noColor"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="noColor"
                                    name="noColor"
                                    value="1"
                                    <?php echo e($job->color == 1 ? 'checked' : ''); ?>

                                >

                                <label
                                    class="form-check-label"
                                    for="noColor"
                                >
                                    Color
                                </label>

                            </div>


                            <div
                                id="noColorFields"
                                style="<?php echo e($job->color == 1 ? 'display:block;' : 'display:none;'); ?>"
                            >

                                <div class="mb-3">

                                    <label
                                        for="color"
                                        class="form-label"
                                    >
                                        Design Colors
                                    </label>

                                    <input
                                        type="number"
                                        id="color"
                                        class="form-control"
                                        name="color"
                                        value="<?php echo e($job->color_no); ?>"
                                    >

                                </div>

                            </div>


                            
                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="window"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="window"
                                    name="window"
                                    value="1"
                                    <?php echo e($job->window == 1 ? 'checked' : ''); ?>

                                >

                                <label
                                    class="form-check-label"
                                    for="window"
                                >
                                    Window
                                </label>

                            </div>


                            <div
                                id="windowOptions"
                                style="<?php echo e($job->window == 1 ? 'display:block;' : 'display:none;'); ?> margin-top:10px; margin-bottom:10px; margin-left:20px;"
                            >

                                <div class="form-check">

                                    <input
                                        type="hidden"
                                        name="glass_win"
                                        value="0"
                                    >

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="glass_win"
                                        name="glass_win"
                                        value="1"
                                        <?php echo e($job->glass_win == 1 ? 'checked' : ''); ?>

                                    >

                                    <label
                                        class="form-check-label"
                                        for="glass_win"
                                    >
                                        Glass Window
                                    </label>

                                </div>


                                <div class="form-check">

                                    <input
                                        type="hidden"
                                        name="lam_win"
                                        value="0"
                                    >

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="lam_win"
                                        name="lam_win"
                                        value="1"
                                        <?php echo e($job->lam_window == 1 ? 'checked' : ''); ?>

                                    >

                                    <label
                                        class="form-check-label"
                                        for="lam_win"
                                    >
                                        Lamination Window
                                    </label>

                                </div>

                            </div>


                            
                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="varnish"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="varnish"
                                    name="varnish"
                                    value="1"
                                    <?php echo e($job->varnish == 1 ? 'checked' : ''); ?>

                                >

                                <label
                                    class="form-check-label"
                                    for="varnish"
                                >
                                    Varnish
                                </label>

                            </div>


                            
                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="emboss"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="emboss"
                                    name="emboss"
                                    value="1"
                                    <?php echo e($job->emboss == 1 ? 'checked' : ''); ?>

                                >

                                <label
                                    class="form-check-label"
                                    for="emboss"
                                >
                                    Embosse
                                </label>

                            </div>


                            <div
                                id="embossFields"
                                style="<?php echo e($job->emboss == 1 ? 'display:block;' : 'display:none;'); ?>"
                            >

                                <!-- <div class="mb-3" >

                                    <label
                                        for="emboss_rate"
                                        class="form-label"
                                    >
                                        Embosse Rate
                                    </label>

                                    <input
                                        type="number"
                                        id="emboss_rate"
                                        class="form-control"
                                        name="emboss_rate"
                                        step="any"
                                        value="<?php echo e($job->emboss_rate); ?>"
                                    >

                                </div> -->

                            </div>


                            
                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="breaking"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="breaking"
                                    name="breaking"
                                    value="1"
                                    <?php echo e($job->breaking == 1 ? 'checked' : ''); ?>

                                >

                                <label
                                    class="form-check-label"
                                    for="breaking"
                                >
                                    Breaking
                                </label>

                            </div>

                        </div>


                        
                        <div class="col-md-12 mb-3">

                            <label>Note</label>

                            <textarea
                                name="note"
                                rows="3"
                                class="form-control"
                            ><?php echo e(old('note', $job->note)); ?></textarea>

                        </div>


                        
                        <div class="col-md-6 mb-3">

                            <label>M.Date</label>

                            <input
                                type="date"
                                name="m_date"
                                class="form-control"
                                value="<?php echo e(old('m_date', $job->m_date ? \Carbon\Carbon::parse($job->m_date)->format('Y-m-d') : '')); ?>"
                            >

                        </div>


                        
                        <div class="col-md-6 mb-3">

                            <label>E.Date</label>

                            <input
                                type="date"
                                name="e_date"
                                class="form-control"
                                value="<?php echo e(old('e_date', $job->e_date ? \Carbon\Carbon::parse($job->e_date)->format('Y-m-d') : '')); ?>"
                            >

                        </div>


                        
                        <div class="col-12">

                            <button
                                type="submit"
                                class="btn btn-success"
                            >
                                Update Job Sheet
                            </button>

                            <a
                                href="<?php echo e(route('tempjob.index')); ?>"
                                class="btn btn-secondary"
                            >
                                Cancel
                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>

$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | SELECT2
    |--------------------------------------------------------------------------
    */

    $('#job_id').select2({
        placeholder: 'Select Job',
        allowClear: true,
        width: '100%'
    });


    function initSelect2(scope) {

        scope.find('.item-selection').select2({
            width: '100%'
        });

        scope.find('.after-cutting').select2({
            width: '100%'
        });

    }


    initSelect2($(document));


    $('#litem').select2({
        width: '100%'
    });


    $('#citem').select2({
        width: '100%'
    });


    /*
    |--------------------------------------------------------------------------
    | BOXBOARD ADD ROW
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.add-row', function () {

        let newRow = $('.item-row:first').clone();

        /*
        |--------------------------------------------------------------------------
        | Remove Select2 generated HTML
        |--------------------------------------------------------------------------
        */

        newRow.find('.select2-container').remove();

        /*
        |--------------------------------------------------------------------------
        | Reset fields
        |--------------------------------------------------------------------------
        */

        newRow.find('select').val('');

        newRow.find('.purchase-vno').val('');

        newRow.find('.total-stock').val('');

        newRow.find('.box-total-stock').val('');

        newRow.find('.box-stock').val('');

        newRow.find('.box-length').val('');

        newRow.find('.box-width').val('');
        newRow.find('.box-grammage').val('');
        $('#boxboard-wrapper').append(newRow);


        /*
        |--------------------------------------------------------------------------
        | Reinitialize Select2
        |--------------------------------------------------------------------------
        */

        initSelect2(newRow);


        calculateBoxes();

    });


    /*
    |--------------------------------------------------------------------------
    | REMOVE ROW
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.remove-row', function () {

        if ($('.item-row').length > 1) {

            $(this)
                .closest('.item-row')
                .remove();

            calculateBoxes();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | CALCULATE BOXES
    |--------------------------------------------------------------------------
    */

    function calculateBoxes() {

        let ups = parseFloat($('#ups').val()) || 0;

        let grandTotal = 0;


        $('.item-row').each(function () {

            let afterCutting =
                parseFloat(
                    $(this)
                        .find('.after-cutting')
                        .val()
                ) || 0;


            let qty =
                parseFloat(
                    $(this)
                        .find('.box-stock')
                        .val()
                ) || 0;


            let sheets = qty * 100;


            grandTotal +=
                ups *
                sheets *
                afterCutting;

        });


        $('#qty_boxes').val(grandTotal);

    }


    /*
    |--------------------------------------------------------------------------
    | ITEM CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on('change', '.item-selection', function () {

        let row = $(this).closest('.item-row');

        let selected = $(this).find(':selected');

        let value = $(this).val();

        let parts = value ? value.split('_') : [];


        let stock =
            parseFloat(
                selected.data('stock')
            ) || 0;


        row.find('.total-stock').val(stock);


        /*
        |--------------------------------------------------------------------------
        | IMPORTANT:
        | Remaining stock = stock - used qty
        |--------------------------------------------------------------------------
        */

        let qty =
            parseFloat(
                row.find('.box-stock').val()
            ) || 0;


        row.find('.box-total-stock')
            .val(stock - qty);
console.log(parts);

        if (parts.length >= 3) {

            row.find('.box-length')
                .val(parts[2]);
            row.find('.box-grammage')
                .val(parts[3]);

            row.find('.box-width')
                .val(parts[1]);

        }

    });


    /*
    |--------------------------------------------------------------------------
    | QTY CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on('input', '.box-stock', function () {

        let row = $(this).closest('.item-row');

        let total =
            parseFloat(
                row.find('.total-stock').val()
            ) || 0;


        let qty =
            parseFloat(
                $(this).val()
            ) || 0;


        if (qty > total) {

            alert('Stock exceed!');

            $(this).val('');

            qty = 0;

        }


        row.find('.box-total-stock')
            .val(total - qty);


        calculateBoxes();

    });


    /*
    |--------------------------------------------------------------------------
    | UPS
    |--------------------------------------------------------------------------
    */

    $(document).on('input', '#ups', function () {

        calculateBoxes();

    });


    /*
    |--------------------------------------------------------------------------
    | AFTER CUTTING
    |--------------------------------------------------------------------------
    */

    $(document).on('change', '.after-cutting', function () {

        calculateBoxes();

    });


    /*
    |--------------------------------------------------------------------------
    | LAMINATION
    |--------------------------------------------------------------------------
    */

    $('#lamination').on('change', function () {

        if ($(this).is(':checked')) {

            $('#laminationFields').show();

        } else {

            $('#laminationFields').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | UV
    |--------------------------------------------------------------------------
    */

    $('#uv').on('change', function () {

        if ($(this).is(':checked')) {

            $('#uvFields').show();

        } else {

            $('#uvFields').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | CORRUGATION
    |--------------------------------------------------------------------------
    */

    $('#corrugation').on('change', function () {

        if ($(this).is(':checked')) {

            $('#corrugationFields').show();

        } else {

            $('#corrugationFields').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | COLOR
    |--------------------------------------------------------------------------
    */

    $('#noColor').on('change', function () {

        if ($(this).is(':checked')) {

            $('#noColorFields').show();

        } else {

            $('#noColorFields').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | WINDOW
    |--------------------------------------------------------------------------
    */

    $('#window').on('change', function () {

        if ($(this).is(':checked')) {

            $('#windowOptions').show();

        } else {

            $('#windowOptions').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | EMBOSS
    |--------------------------------------------------------------------------
    */

    $('#emboss').on('change', function () {

        if ($(this).is(':checked')) {

            $('#embossFields').show();

        } else {

            $('#embossFields').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | INITIAL BOXBOARD STOCK
    |--------------------------------------------------------------------------
    */

    $('.item-selection').each(function () {

        let row = $(this).closest('.item-row');

        let selected = $(this).find(':selected');

        let stock =
            parseFloat(
                selected.data('stock')
            ) || 0;


        /*
        |--------------------------------------------------------------------------
        | Existing edit row:
        | current stock from boxboard_stock_qty
        |--------------------------------------------------------------------------
        */

        row.find('.total-stock').val(stock);


        let qty =
            parseFloat(
                row.find('.box-stock').val()
            ) || 0;


        /*
        |--------------------------------------------------------------------------
        | Don't show negative remaining stock
        |--------------------------------------------------------------------------
        */

        row.find('.box-total-stock')
            .val(stock - qty);

    });


    /*
    |--------------------------------------------------------------------------
    | INITIAL BOX CALCULATION
    |--------------------------------------------------------------------------
    */

    calculateBoxes();

});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/temp_job_sheet/edit.blade.php ENDPATH**/ ?>