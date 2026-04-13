
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box text-center">
                <h4 class="page-title">Employee Details</h4>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <div class="col-lg-10 mx-auto">
        <div class="card shadow-sm border">
            <div class="card-body" id="printable-area">

                <!-- Print-only heading -->
                <h1 class="print-only-heading" style="display:none;">Employee Details</h1>


                <!-- Employee Info -->
                <div class="details-grid">
                    <div class="detail-item">
                        <label class="form-label">Joining Date</label>
                        <div class="form-control-plaintext border-bottom"><?php echo e(optional($employee)->joining_date); ?></div>
                    </div>

                    <div class="detail-item">
                        <label class="form-label">Name</label>
                        <div class="form-control-plaintext border-bottom"><?php echo e($employee->fname); ?></div>
                    </div>

                    <div class="detail-item">
                        <label class="form-label">Father Name</label>
                        <div class="form-control-plaintext border-bottom"><?php echo e($employee->lname); ?></div>
                    </div>

                    <div class="detail-item">
                        <label class="form-label">Phone No</label>
                        <div class="form-control-plaintext border-bottom"><?php echo e($employee->phone_no); ?></div>
                    </div>

                    <div class="detail-item">
                        <label class="form-label">Blood Group</label>
                        <div class="form-control-plaintext border-bottom"><?php echo e($employee->blood_group); ?></div>
                    </div>

                    <div class="detail-item">
                        <label class="form-label">Address</label>
                        <div class="form-control-plaintext border-bottom"><?php echo e($employee->address); ?></div>
                    </div>

                    <div class="detail-item">
                        <label class="form-label">Employee Type</label>
                        <div class="form-control-plaintext border-bottom"><?php echo e(ucfirst($employee->employee)); ?></div>
                    </div>

                    <div class="detail-item">
                        <label class="form-label">CNIC</label>
                        <div class="form-control-plaintext border-bottom"><?php echo e($employee->cnic_no); ?></div>
                    </div>
                </div>

                <div class="mb-2 text-center">
                    <label class="form-label d-block">CNIC Front Side</label>
                    <?php if($employee->cnic_front_path): ?>
                        <img src="<?php echo e(asset('storage/' . $employee->cnic_front_path)); ?>" alt="CNIC Front" class="img-thumbnail shadow-sm">
                    <?php else: ?>
                        <div class="text-muted">No front image</div>
                    <?php endif; ?>
                </div>

                <div class="mb-2 text-center">
                    <label class="form-label d-block">CNIC Back Side</label>
                    <?php if($employee->cnic_back_path): ?>
                        <img src="<?php echo e(asset('storage/' . $employee->cnic_back_path)); ?>" alt="CNIC Back" class="img-thumbnail shadow-sm">
                    <?php else: ?>
                        <div class="text-muted">No back image</div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Bonus Type</label>
                        <div class="form-control-plaintext border-bottom"><?php echo e(optional($employee->bonus)->name ?? $employee->bonus_title ?? '—'); ?></div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Rate</label>
                        <div class="form-control-plaintext border-bottom"><?php echo e($employee->bonus_rate ?? '—'); ?></div>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="mt-3 text-center no-print">
                    <a href="<?php echo e(route('employees.reports')); ?>" class="btn btn-secondary">Back</a>
                    <a href="<?php echo e(route('employees.edit', $employee->id)); ?>" class="btn btn-primary">Edit</a>
                    <button type="button" class="btn btn-info" onclick="window.print();">Print</button>
                </div>

            </div>
        </div>
    </div>
</div>


<style>
/* Shared visual refinements */
#employee-details,
#printable-area {
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 1.2rem 1.5rem;
    background-color: #fff;
}

.form-label {
    font-weight: 600;
    color: #333;
}

.form-control-plaintext {
    padding: 4px 0;
    font-size: 0.95rem;
}

/* ⬆️ Increased image size on screen */
.img-thumbnail {
    max-width: 300px; /* was 200px */
    border-radius: 10px;
    border: 1px solid #ccc;
}

/* Print-specific styles */
@media print {
    .no-print {
        display: none !important;
    }

    .page-title-box,
    .alert {
        display: none !important;
    }

    @page {
        size: A4 portrait;
        margin: 0.4cm;
    }

    body {
        font-family: "Segoe UI", Arial, sans-serif !important;
        background: #fff !important;
        font-size: 10pt;
        color: #000;
        -webkit-print-color-adjust: exact;
    }

    #printable-area {
        border: 1px solid #000 !important;
        border-radius: 6px;
        padding: 0.6cm;
        margin: 0;
        width: 100%;
        max-width: none;
        box-sizing: border-box;
    }

    .print-only-heading {
        display: block !important;
        text-align: center;
        font-size: 16pt;
        font-weight: 600;
        margin-bottom: 0.4rem;
        border-bottom: 2px solid #000;
        text-transform: uppercase;
    }

    .mb-2 {
        margin-bottom: 0.3rem !important;
    }

    .mt-3 {
        margin-top: 0.4rem !important;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        font-size: 0.9em;
    }

    .form-control-plaintext {
        padding: 3px 0;
        font-size: 0.9em;
    }

    /* ⬆️ Increased image size for print */
    .img-thumbnail {
        max-width: 250px !important; /* was 120px */
        max-height: 250px !important;
        border: 1px solid #666;
        border-radius: 10px;
    }

    .card,
    .card-body {
        border: none !important;
        background: none !important;
        box-shadow: none !important;
        margin: 0;
        padding: 0;
    }

    html,
    body {
        height: auto !important;
        overflow: visible !important;
        margin: 0 !important;
        padding: 0 !important;
    }
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/employees/show.blade.php ENDPATH**/ ?>