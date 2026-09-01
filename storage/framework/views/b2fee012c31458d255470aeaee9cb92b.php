

<?php $__env->startSection('content'); ?>

<style>

    body {
        background: #f3f6fa;
    }

    .quotation-wrapper {
        max-width: 1050px;
        margin: 30px auto;
    }

    .quotation-card {
        background: #fff;
        padding: 45px 50px;
        box-shadow: 0 8px 35px rgba(15, 30, 55, 0.08);
    }


    /* =========================================================
       TOP HEADER
    ========================================================= */

    .quotation-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 22px;
        border-bottom: 1px solid #ddd;
    }

    .company-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .company-logo {
        width: 65px;
        height: 65px;
        object-fit: contain;
    }

    .company-name {
        margin: 0;
        font-size: 25px;
        font-weight: 800;
        color: #000;
        line-height: 1.1;
    }

    .company-name span {
        color: #e9252b;
    }

    .company-tagline {
        margin-top: 5px;
        font-size: 11px;
        color: #526d89;
        font-weight: 600;
    }

    .quotation-heading {
        text-align: right;
    }

    .quotation-heading h1 {
        margin: 0;
        font-size: 38px;
        font-weight: 800;
        color: #000;
        letter-spacing: .5px;
    }

    .quotation-number {
        margin-top: 5px;
        font-size: 13px;
        color: #526d89;
    }


    /* =========================================================
       TOP ACTIONS
    ========================================================= */

    .top-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 18px;
    }

    .btn-quotation {
        border: 1px solid #d7e0eb;
        background: #fff;
        color: #0f1e37;
        border-radius: 9px;
        padding: 8px 16px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .btn-quotation:hover {
        background: #f5f7fa;
        color: #0f1e37;
    }

    .btn-gold {
        background: #dda42e;
        border-color: #dda42e;
        color: #fff;
    }

    .btn-gold:hover {
        background: #c99225;
        border-color: #c99225;
        color: #fff;
    }


    /* =========================================================
       QUOTATION INFORMATION
    ========================================================= */

    .quotation-info {
        margin-top: 25px;
        margin-bottom: 20px;
    }

    .quotation-info-row {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
        font-size: 18px;
        color: #000;
    }

    .quotation-info-label {
        font-weight: 700;
        min-width: 55px;
    }

    .quotation-info-value {
        font-weight: 400;
    }


    /* =========================================================
       ITEMS TABLE
    ========================================================= */

    .quotation-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
    }

    .quotation-table th {
        background: #d3d3d3;
        color: #000;
        font-size: 17px;
        font-weight: 700;
        text-align: left;
        padding: 12px 16px;
        border: 1px solid #222;
    }

    .quotation-table td {
        color: #000;
        font-size: 17px;
        padding: 12px 16px;
        border: 1px solid #222;
        vertical-align: middle;
    }

    .quotation-table th:first-child {
        width: 43%;
    }

    .quotation-table th:last-child {
        width: 57%;
    }

    .item-name {
        font-weight: 700;
    }

    .item-details {
        font-weight: 400;
    }


    /* =========================================================
       NOTES
    ========================================================= */

    .quotation-notes {
        margin-top: 32px;
        font-size: 17px;
        line-height: 1.7;
        color: #000;
    }

    .quotation-notes strong {
        font-weight: 700;
    }


    /* =========================================================
       BOTTOM ACTIONS
    ========================================================= */

    .bottom-actions {
        display: flex;
        gap: 10px;
        padding-top: 25px;
        margin-top: 30px;
        border-top: 1px solid #dfe5ec;
    }

    .btn-dark {
        background: #0f1e37;
        color: #fff;
        border: 1px solid #0f1e37;
        border-radius: 10px;
        padding: 9px 18px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .btn-dark:hover {
        background: #192a46;
        color: #fff;
    }

    .btn-danger-custom {
        background: #e9252b;
        color: #fff;
        border: 1px solid #e9252b;
        border-radius: 10px;
        padding: 9px 18px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .btn-danger-custom:hover {
        background: #cc1c22;
        color: #fff;
    }

    .btn-close-custom {
        background: #fff;
        color: #0f1e37;
        border: 1px solid #d7e0eb;
        border-radius: 10px;
        padding: 9px 18px;
        font-weight: 600;
        text-decoration: none;
    }


    /* =========================================================
       PRINT
    ========================================================= */

   @media print {

    @page {
        size: A4;
        margin: 15mm;
    }

    html,
    body {
        background: #fff !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100%;
    }

    .quotation-wrapper {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .quotation-card {
        width: 100% !important;
        max-width: none !important;
        box-shadow: none !important;
        padding: 25px 30px !important;
        margin: 0 !important;
    }

    .no-print {
        display: none !important;
    }


    /* =========================================================
       PRINT HEADER
    ========================================================== */

    .quotation-header {
        display: flex !important;
        flex-direction: row !important;
        justify-content: space-between !important;
        align-items: flex-start !important;

        width: 100% !important;

        padding-bottom: 20px !important;

        border-bottom: 1px solid #ddd !important;
    }


    /* LEFT SIDE */

    .company-left {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;

        width: 60% !important;
        flex: 0 0 60% !important;

        gap: 15px !important;
    }

    .company-logo {
        display: block !important;

        width: 65px !important;
        height: 65px !important;

        object-fit: contain !important;

        flex-shrink: 0 !important;
    }

    .company-name {
        margin: 0 !important;

        font-size: 25px !important;
        line-height: 1.1 !important;

        white-space: nowrap !important;
    }

    .company-tagline {
        margin-top: 5px !important;
        font-size: 11px !important;
    }


    /* RIGHT SIDE */

    .quotation-heading {
        display: block !important;

        width: 40% !important;
        flex: 0 0 40% !important;

        text-align: right !important;
    }

    .quotation-heading h1 {
        margin: 0 !important;

        font-size: 38px !important;
        line-height: 1.1 !important;

        white-space: nowrap !important;
    }

    .quotation-number {
        margin-top: 5px !important;

        font-size: 13px !important;

        text-align: right !important;
    }


    /* =========================================================
       QUOTATION INFO
    ========================================================== */

    .quotation-info {
        margin-top: 25px !important;
        margin-bottom: 20px !important;
    }

    .quotation-info-row {
        display: flex !important;
        align-items: center !important;

        font-size: 18px !important;
    }


    /* =========================================================
       TABLE
    ========================================================== */

    .quotation-table {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    .quotation-table th {
        background: #d3d3d3 !important;
        color: #000 !important;

        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;

        border: 1px solid #222 !important;
    }

    .quotation-table td {
        border: 1px solid #222 !important;
        color: #000 !important;
    }


    /* =========================================================
       NOTES
    ========================================================== */

    .quotation-notes {
        page-break-inside: avoid !important;
    }

}


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 768px) {

        .quotation-wrapper {
            margin: 10px;
        }

        .quotation-card {
            padding: 25px;
        }

        .quotation-header {
            flex-direction: column;
            gap: 20px;
        }

        .quotation-heading {
            text-align: left;
        }

        .quotation-heading h1 {
            font-size: 30px;
        }

        .quotation-info-row {
            font-size: 16px;
        }

        .quotation-table {
            min-width: 650px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

    }

</style>


<div class="quotation-wrapper">

    <div class="quotation-card">


        

        <div class="quotation-header">

            
            <div class="company-left">

                <img
                    src="<?php echo e(asset('assets/images/prologo.jpg')); ?>"
                    alt="Pro-Box Packages"
                    class="company-logo"
                >

                <div>

                    <h2 class="company-name">
                        Pro-<span>Box</span> Packages
                    </h2>

                    <div class="company-tagline">
                        Printing & Packaging Solution
                    </div>

                </div>

            </div>


            
            <div class="quotation-heading">

                <h1>
                    QUOTATION
                </h1>

                <?php if(!empty($quotation->quotation_no)): ?>

                    <div class="quotation-number">
                        Quotation No:
                        <strong><?php echo e($quotation->quotation_no); ?></strong>
                    </div>

                <?php endif; ?>

            </div>

        </div>


        

        <div class="top-actions no-print">

            <a
                href="<?php echo e(route('quotations.index')); ?>"
                class="btn-quotation"
            >
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

            <button
                type="button"
                class="btn-quotation"
                onclick="window.print()"
            >
                <i class="fas fa-print"></i>
                Print
            </button>

            <a
                href="<?php echo e(route('quotations.pdf', $quotation->id)); ?>"
                class="btn-quotation btn-gold"
            >
                <i class="fas fa-file-pdf"></i>
                PDF
            </a>

        </div>


        

        <div class="quotation-info">
        
            <div class="quotation-info-row">

                <span class="quotation-info-label">
                    To:
                </span>

                <span class="quotation-info-value">
                    <?php echo e($quotation->party_name ?? 'N/A'); ?>

                </span>

            </div>


            
            <div class="quotation-info-row">

                <span class="quotation-info-label">
                    Date:
                </span>

                <span class="quotation-info-value">

                    <?php echo e(\Carbon\Carbon::parse($quotation->quotation_date)->format('d F Y')); ?>


                </span>

            </div>

        </div>


        

        <div class="table-wrapper">

            <table class="quotation-table">

                <thead>

                    <tr>

                        <th>
                            Item
                        </th>

                        <th>
                            Description
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $quotation->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <tr>

                            <td>

                                <div class="item-name">
                                    <?php echo e($item->item_name); ?>

                                </div>

                            </td>

                            <td>

                                <div class="item-details">
                                    <?php echo e($item->item_details ?: '-'); ?>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>

                            <td colspan="2">

                                No quotation items found.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>


        

        <div class="quotation-notes">

            <?php if(!empty($quotation->description)): ?>

                <?php echo nl2br(e($quotation->description)); ?>


            <?php else: ?>

                Thank you for choosing
                <strong>Pro-Box Packages</strong>.
                We look forward to serving you.

            <?php endif; ?>

        </div>


        

        <div class="bottom-actions no-print">

            <a
                href="<?php echo e(route('quotations.edit', $quotation->id)); ?>"
                class="btn-dark"
            >

                <i class="fas fa-edit"></i>

                Edit

            </a>


            <form
                action="<?php echo e(route('quotations.destroy', $quotation->id)); ?>"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete this quotation?');"
                style="display:inline;"
            >

                <?php echo csrf_field(); ?>

                <?php echo method_field('DELETE'); ?>

                <button
                    type="submit"
                    class="btn-danger-custom"
                >

                    <i class="fas fa-trash"></i>

                    Delete

                </button>

            </form>


            <a
                href="<?php echo e(route('quotations.index')); ?>"
                class="btn-close-custom"
            >
                Close
            </a>

        </div>


    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/quotations/show.blade.php ENDPATH**/ ?>