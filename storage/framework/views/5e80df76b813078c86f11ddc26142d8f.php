<?php $__env->startSection('content'); ?>
<div class="container my-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold m-0">Packaging Specification Details</h4>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('packaging-specs.print', $packagingSpec->id)); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-printer"></i> Print
            </a>
            <a href="<?php echo e(route('packaging-specs.edit', $packagingSpec->id)); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="<?php echo e(route('packaging-specs.index')); ?>" class="btn btn-sm btn-outline-dark">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="spec-container">
        <style>
            /* ===== LANDSCAPE STYLES ===== */
            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 14px;
                background: #fff;
                color: #222;
            }

            .spec-container {
                border: 1.5px solid #000;
                width: 280mm;
                height: 200mm;
                padding: 20px;
                margin: auto;
                background: #fff;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                box-sizing: border-box;
            }

            .header-section {
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
                margin-bottom: 10px;
                padding-bottom: 4px;
            }

            .header-item {
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .spec-label {
                font-weight: bold;
                min-width: 90px;
            }

            .spec-value {
                border-bottom: 1px solid #666;
                flex: 1;
                margin-left: 4px;
                padding: 1px 2px 0 2px;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                line-height: 1.3;
            }

            .spec-value.bold-large {
                font-size: 1.15em;
                font-weight: bold;
            }

            .main-layout {
                display: flex;
                gap: 30px;
                flex: 1 1 auto;
                min-height: 0;
                overflow: hidden;
            }

            .left-col {
                flex: 1.3;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .right-col {
                flex: 0 0 350px;
                display: flex;
                flex-direction: column;
                gap: 15px;
                height: 100%;
            }

            .specs-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 6px 10px;
            }

            .spec-row {
                display: flex;
                align-items: baseline;
            }

            .box-type-row {
                display: flex;
                align-items: baseline;
                margin: 10px 0;
            }

            .ups-table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
                margin-top: 4px;
                font-size: 0.9em;
            }

            .ups-table th, .ups-table td {
                border: 1px solid #aaa;
                padding: 3px;
            }

            .ups-table th {
                font-weight: bold;
                background: #ffffffff;
                color: #222;
            }

            .box-details {
                border: 1px solid #ffffffff;
                padding: 8px;
                font-size: 0.9em;
                background: #ffffffff;
            }

            .box-details-title {
                font-weight: bold;
                text-decoration: underline;
                margin-bottom: 5px;
            }

            .diagram-section {
                border: 1px dashed #ffffffff;
                border-radius: 6px;
                background: #ffffffff;
                height: 160px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
            }

            .diagram-img,
            .diagram-embed {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .finishing-wrapper {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 12px 20px;
                margin-top: 15px;
            }

            .finishing-col {
                display: flex;
                flex-direction: column;
                gap: 3px;
            }

            .col-label {
                font-weight: bold;
                margin-bottom: 2px;
            }

            .finishing-item {
                display: flex;
                align-items: center;
                font-size: 0.85em;
            }

            .checkbox-box {
                width: 14px;
                height: 14px;
                border: 1px solid #222;
                margin-right: 4px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 10px;
                font-weight: bold;
                color: #222;
                background: #fff;
            }

            .checkbox-checked {
                background: #222;
                color: #fff;
            }

            /* For smaller screens */
            @media screen and (max-width: 992px) {
                .spec-container {
                    width: 100%;
                    height: auto;
                }

                .main-layout {
                    flex-direction: column;
                }

                .right-col {
                    flex: unset;
                }
            }
        </style>

        
        <div class="header-section">
            <div class="header-item">
                <span class="spec-label bold-large">Company Name</span>:
                <span class="spec-value bold-large"><?php echo e($packagingSpec->company_name); ?></span>
            </div>
            <div class="header-item">
                <span class="spec-label">Date</span>:
                <span class="spec-value"><?php echo e($packagingSpec->date); ?></span>
            </div>
        </div>

        <div class="spec-row mb-2">
            <span class="spec-label bold-large">Item Name</span>:
            <span class="spec-value bold-large"><?php echo e($packagingSpec->item_name); ?></span>
        </div>

        <div class="main-layout">
            <div class="left-col">

                
                <div class="spec-row">
                    <span class="spec-label">Sizes</span>:
                    <div class="spec-value" style="flex:1; display:block;">
                        <?php if($packagingSpec->details && $packagingSpec->details->count()): ?>
                            <table class="ups-table">
                                <thead>
                                    <tr>
                                        <th>UPS</th>
                                        <th>Manual Die Size</th>
                                        <th>Auto Die Size</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $packagingSpec->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($d->ups); ?></td>
                                            <td><?php echo e($d->printing_size); ?></td>
                                            <td><?php echo e($d->board_size); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div style="display:flex; gap:10px;">
                                <span style="flex:1;"><?php echo e($packagingSpec->printing_size ?? '—'); ?></span>
                                <span style="flex:1;"><?php echo e($packagingSpec->board_size ?? '—'); ?></span>
                                <span style="flex:1;"><?php echo e($packagingSpec->ups ?? '—'); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>


                
                <div class="custom-specs-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px 40px; margin-bottom: 15px;">
                    <!-- Row 1 -->
                    <div class="spec-row"><span class="spec-label">Designing Color</span>: <span class="spec-value"><?php echo e($packagingSpec->designing_color ?? '—'); ?></span></div>
                    <div class="spec-row"><span class="spec-label">Length</span>: <span class="spec-value"><?php echo e($packagingSpec->length); ?></span> <span class="unit"><?php echo e($packagingSpec->unit); ?></span></div>
                    <!-- Row 2 -->
                    <div class="spec-row"><span class="spec-label">Printing Side</span>: <span class="spec-value"><?php echo e($packagingSpec->printing_side ?? '—'); ?></span></div>
                    <div class="spec-row"><span class="spec-label">Width</span>: <span class="spec-value"><?php echo e($packagingSpec->width); ?></span> <span class="unit"><?php echo e($packagingSpec->unit); ?></span></div>
                    <!-- Row 3 -->
                    <div class="spec-row"><span class="spec-label">Lamination Size</span>: <span class="spec-value"><?php echo e($packagingSpec->lam_size); ?></span></div>
                    <div class="spec-row"><span class="spec-label">Height</span>: <span class="spec-value"><?php echo e($packagingSpec->height); ?></span> <span class="unit"><?php echo e($packagingSpec->unit); ?></span></div>
                    <!-- Row 4 -->
                    <div class="spec-row"><span class="spec-label">Flute Size</span>: <span class="spec-value"><?php echo e($packagingSpec->flute_size); ?></span></div>
                    <div class="spec-row"><span class="spec-label">UV Size</span>: <span class="spec-value"><?php echo e($packagingSpec->uv_size); ?></span></div>
                 
                    <div>
                           <div class="spec-row"><span class="spec-label">Country</span>: <span class="spec-value"><?php echo e($packagingSpec->country); ?></span></div>
                    </div>
                </div>

                
                <div class="box-type-row">
                    <span class="spec-label">Box Type</span>:
                    <span class="spec-value" style="max-width: 180px; font-size: 0.95em; padding: 1px 4px;">
                        <?php echo e(optional($packagingSpec->boxType)->item_code ?? ($packagingSpec->box_type ?? 'N/A')); ?>

                    </span>
                </div>

                
                <div class="finishing-wrapper">
                    <div class="finishing-col">
                        <div class="col-label">Finishing</div>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->emboss ? ' checkbox-checked' : ''); ?>"></span>Emboss</label>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->demboss ? ' checkbox-checked' : ''); ?>"></span>Deboss</label>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->gold_finish ? ' checkbox-checked' : ''); ?>"></span>Gold finish</label>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->silver_finish ? ' checkbox-checked' : ''); ?>"></span>Silver finish</label>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->varnish ? ' checkbox-checked' : ''); ?>"></span>Varnish</label>
                    </div>

                    <div class="finishing-col">
                        <div class="col-label">UV</div>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->uv_plain ? ' checkbox-checked' : ''); ?>"></span>Plain</label>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->uv_spot ? ' checkbox-checked' : ''); ?>"></span>Spot</label>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->uv_drip ? ' checkbox-checked' : ''); ?>"></span>Drip</label>
                    </div>

                    <div class="finishing-col">
                        <div class="col-label">Window</div>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->window_lamination ? ' checkbox-checked' : ''); ?>"></span>Lamination</label>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->window_glass ? ' checkbox-checked' : ''); ?>"></span>Glass</label>
                    </div>

                    <div class="finishing-col">
                        <div class="col-label">Lamination</div>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->shine_lamination ? ' checkbox-checked' : ''); ?>"></span>Shine</label>
                        <label class="finishing-item"><span class="checkbox-box<?php echo e($packagingSpec->matte_lamination ? ' checkbox-checked' : ''); ?>"></span>Matt</label>
                    </div>
                </div>

            </div>

            <div class="right-col" style="position: relative; min-height: 350px;">

                
                <div class="box-details">
                    <div class="box-details-title">Box Details</div>
                    <div><strong>Glue Flap:</strong> <?php echo e($packagingSpec->glue_flap); ?></div>
                    <div><strong>Folding Flap:</strong> <?php echo e($packagingSpec->holding_flap); ?></div>
                    <div><strong>Pendi:</strong> <?php echo e($packagingSpec->pendi); ?></div>
                    <div><strong>Die Grip:</strong> <?php echo e($packagingSpec->die_grip); ?></div>
                    <div><strong>Die Pattern:</strong> <?php echo e($packagingSpec->die_pattern); ?></div>
                </div>

                
                <div style="position: absolute; bottom: 0; right: 0; width: 500px; height: 320px;">
                    <div class="diagram-section" style="width: 100%; height: 100%;">
                        <?php if($packagingSpec->image_path): ?>
                            <?php $ext = pathinfo($packagingSpec->image_path, PATHINFO_EXTENSION); ?>
                            <?php if(strtolower($ext) === 'pdf'): ?>
                                <embed src="<?php echo e(asset('storage/' . $packagingSpec->image_path)); ?>" type="application/pdf" class="diagram-embed" />
                            <?php else: ?>
                                <img src="<?php echo e(asset('storage/' . $packagingSpec->image_path)); ?>" class="diagram-img" />
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-muted small">No image uploaded</span>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/packaging_specs/show.blade.php ENDPATH**/ ?>