

<?php $__env->startSection('content'); ?>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    /* =========================================================
       PAGE
    ========================================================= */

    .die-page {
        min-height: calc(100vh - 70px);
        background: #f3f6fb;
        padding: 28px 0 50px;
        font-family: inherit;
    }

    .die-container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 32px;
        padding: 44px 51px 58px;
        box-shadow: 0 18px 45px rgba(31, 51, 73, 0.08);
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .die-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
        padding-bottom: 28px;
        border-bottom: 2px solid #edf1f5;
    }

    .die-title-area {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .die-title-icon {
        width: 46px;
        height: 46px;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #2864e8;
        font-size: 42px;
        line-height: 1;
    }

    .die-title {
        margin: 0;
        color: #071b39;
        font-size: 40px;
        line-height: 1.1;
        font-weight: 800;
        letter-spacing: -1.2px;
    }


    /* =========================================================
       TOP BUTTONS
    ========================================================= */

    .die-header-actions {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .die-top-btn {
        height: 54px;
        border: none;
        border-radius: 30px;

        padding: 0 27px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 11px;

        font-size: 17px;
        font-weight: 700;

        cursor: pointer;
        transition: all .2s ease;

        text-decoration: none;
    }

    .die-top-btn i {
        font-size: 18px;
    }

    .die-print-btn {
        background: #1d2b41;
        color: #ffffff;
    }

    .die-print-btn:hover {
        background: #142135;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .die-new-btn {
        background: #2864e8;
        color: #ffffff;
    }

    .die-new-btn:hover {
        background: #1e54cb;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(40, 100, 232, .22);
    }

    .die-add-btn {
        background: #0fa44b;
        color: #ffffff;
    }

    .die-add-btn:hover {
        background: #0b8d3f;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(15, 164, 75, .20);
    }


    /* =========================================================
       TABLE
    ========================================================= */

    .die-table-wrapper {
        margin-top: 42px;

        border: 1px solid #dfe6ee;
        border-radius: 24px;

        overflow: hidden;

        background: #ffffff;
    }

    .die-table-scroll {
        width: 100%;
        overflow-x: auto;
    }

    .die-table {
        width: 100%;
        min-width: 1050px;

        border-collapse: separate;
        border-spacing: 0;
    }

    .die-table thead {
        background: #f1f5f9;
    }

    .die-table th {
        height: 64px;

        padding: 0 24px;

        color: #243c5a;

        font-size: 16px;
        font-weight: 700;

        text-align: left;

        text-transform: uppercase;
        letter-spacing: .2px;

        white-space: nowrap;

        border-bottom: 2px solid #dce4ec;
    }

    .die-table td {
        height: 72px;

        padding: 0 24px;

        color: #172b45;

        font-size: 16px;
        font-weight: 500;

        border-bottom: 1px solid #e7edf3;

        white-space: nowrap;
    }

    .die-table tbody tr:last-child td {
        border-bottom: none;
    }

    .die-table tbody tr {
        transition: background .15s ease;
    }

    .die-table tbody tr:hover {
        background: #fafcff;
    }

    .die-table th:first-child,
    .die-table td:first-child {
        width: 70px;
    }

    .die-table th:last-child,
    .die-table td:last-child {
        text-align: center;
    }


    /* =========================================================
       ITEM NAME
    ========================================================= */

    .die-item-name {
        color: #132b49;
        font-size: 18px;
        font-weight: 750;
    }

    .die-product-id {
        display: block;
        margin-top: 3px;

        color: #94a3b8;
        font-size: 11px;
        font-weight: 500;
    }


    /* =========================================================
       SIZE
    ========================================================= */

    .die-size {
        color: #253b57;
        font-size: 16px;
        font-weight: 500;
    }


    /* =========================================================
       RATE
    ========================================================= */

    .die-rate {
        color: #243a57;
        font-size: 17px;
        font-weight: 500;
    }


    /* =========================================================
       UP
    ========================================================= */

    .die-up {
        color: #253c59;
        font-size: 16px;
        font-weight: 500;
    }


    /* =========================================================
       TYPE BADGE
    ========================================================= */

    .die-type-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-width: 81px;
        height: 32px;

        padding: 0 17px;

        border-radius: 18px;

        font-size: 15px;
        font-weight: 700;
    }

    .die-type-new {
        background: #dceafe;
        color: #1555ce;
    }

    .die-type-repeat {
        background: #fff0bd;
        color: #bc6900;
    }


    /* =========================================================
       REPEAT DATE
    ========================================================= */

    .die-repeat-date {
        color: #263c57;
        font-size: 16px;
    }

    .die-empty-value {
        color: #1f324b;
        font-size: 19px;
    }


    /* =========================================================
       REPAIR BADGE
    ========================================================= */

    .die-repair-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-width: 65px;
        height: 32px;

        padding: 0 12px;

        border-radius: 17px;

        background: #eee7ff;
        color: #713cff;

        font-size: 15px;
        font-weight: 700;

        gap: 6px;
    }

    .die-repair-badge i {
        font-size: 13px;
    }


    /* =========================================================
       ACTION BUTTONS
    ========================================================= */

    .die-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    .die-action-btn {
        width: 43px;
        height: 36px;

        border: none;
        border-radius: 18px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        font-size: 17px;

        cursor: pointer;

        transition: all .18s ease;
    }

    .die-action-btn:hover {
        transform: translateY(-1px);
    }


    /* View */

    .die-view-btn {
        background: #e7edf4;
        color: #24425f;
    }

    .die-view-btn:hover {
        background: #dce5ef;
    }


    /* Edit */

    .die-edit-btn {
        background: #dceaff;
        color: #155bd6;
    }

    .die-edit-btn:hover {
        background: #cbdfff;
    }


    /* Repeat */

    .die-repeat-btn {
        background: #fff1c9;
        color: #b85d00;
    }

    .die-repeat-btn:hover {
        background: #ffe8a6;
    }


    /* Repair */

    .die-repair-btn {
        background: #eee7ff;
        color: #733cff;
    }

    .die-repair-btn:hover {
        background: #e4d9ff;
    }


    /* Delete */

    .die-delete-btn {
        background: #ffe0e1;
        color: #e3262f;
    }

    .die-delete-btn:hover {
        background: #ffd0d2;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .die-empty-row {
        text-align: center !important;
        padding: 70px 20px !important;
        height: auto !important;
    }

    .die-empty-icon {
        width: 70px;
        height: 70px;

        margin: 0 auto 15px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 20px;

        background: #edf3fb;
        color: #7f94ad;

        font-size: 27px;
    }

    .die-empty-title {
        margin: 0 0 5px;

        color: #243b58;
        font-size: 18px;
        font-weight: 700;
    }

    .die-empty-text {
        margin: 0;

        color: #8796a8;
        font-size: 13px;
    }


    /* =========================================================
       MODAL
    ========================================================= */

    .die-modal {
        position: fixed;
        inset: 0;

        z-index: 9999;

        display: none;
        align-items: center;
        justify-content: center;

        padding: 20px;

        background: rgba(15, 27, 43, .45);
        backdrop-filter: blur(4px);
    }

    .die-modal.active {
        display: flex;
    }

    .die-modal-card {
        width: 100%;
        max-width: 650px;

        background: #ffffff;

        border-radius: 25px;

        box-shadow: 0 25px 70px rgba(15, 23, 42, .20);

        overflow: hidden;

        animation: dieModalIn .22s ease;
    }

    @keyframes dieModalIn {

        from {
            opacity: 0;
            transform: translateY(15px) scale(.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

    }

    .die-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 22px 25px;

        border-bottom: 1px solid #e8edf3;
    }

    .die-modal-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .die-modal-title-icon {
        width: 42px;
        height: 42px;

        border-radius: 12px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #e8f0ff;
        color: #2864e8;
    }

    .die-modal-title h3 {
        margin: 0;

        color: #102744;
        font-size: 19px;
        font-weight: 750;
    }

    .die-modal-title p {
        margin: 2px 0 0;

        color: #8b9aac;
        font-size: 12px;
    }

    .die-modal-close {
        width: 37px;
        height: 37px;

        border: none;
        border-radius: 50%;

        background: #f1f5f9;
        color: #64748b;

        cursor: pointer;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .die-modal-close:hover {
        background: #e2e8f0;
    }


    /* =========================================================
       FORM
    ========================================================= */

    .die-form {
        padding: 25px;
    }

    .die-form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 19px;
    }

    .die-form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .die-form-group.full {
        grid-column: 1 / -1;
    }

    .die-form-label {
        color: #344b66;
        font-size: 13px;
        font-weight: 700;
    }

    .die-required {
        color: #e3262f;
    }

    .die-form-control {
        width: 100%;
        height: 45px;

        padding: 0 13px;

        border: 1px solid #d8e0e9;
        border-radius: 11px;

        background: #ffffff;

        color: #1d334e;

        font-size: 13px;

        outline: none;

        transition: all .18s ease;
    }

    .die-form-control:focus {
        border-color: #2864e8;
        box-shadow: 0 0 0 3px rgba(40, 100, 232, .09);
    }

    .die-form-control[readonly] {
        background: #f5f7fa;
        color: #60738a;
        cursor: not-allowed;
    }

    .die-product-info {
        display: none;

        grid-column: 1 / -1;

        padding: 15px 17px;

        border: 1px solid #dce8fb;
        border-radius: 13px;

        background: #f5f9ff;
    }

    .die-product-info.active {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 18px;
    }

    .die-info-label {
        color: #8090a2;

        font-size: 10px;
        font-weight: 700;

        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .die-info-value {
        margin-top: 3px;

        color: #173352;

        font-size: 14px;
        font-weight: 700;
    }

    .die-form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;

        margin-top: 24px;
        padding-top: 20px;

        border-top: 1px solid #e9edf2;
    }

    .die-form-btn {
        height: 44px;

        padding: 0 20px;

        border: none;
        border-radius: 10px;

        font-size: 13px;
        font-weight: 700;

        cursor: pointer;
    }

    .die-cancel-btn {
        background: #edf1f5;
        color: #43566d;
    }

    .die-submit-btn {
        background: #2864e8;
        color: #ffffff;
    }

    .die-submit-btn:hover {
        background: #1e54cb;
    }


    /* =========================================================
       ALERT
    ========================================================= */

    .die-alert {
        display: flex;
        align-items: center;
        gap: 10px;

        margin-top: 22px;
        padding: 12px 15px;

        border-radius: 11px;

        font-size: 13px;
    }

    .die-alert-success {
        background: #e4f8eb;
        color: #087b37;
    }

    .die-alert-danger {
        background: #ffe7e8;
        color: #b51d25;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1250px) {

        .die-container {
            padding: 35px 30px 45px;
        }

        .die-title {
            font-size: 32px;
        }

        .die-top-btn {
            height: 48px;
            padding: 0 21px;
            font-size: 15px;
        }

    }


    @media (max-width: 900px) {

        .die-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .die-header-actions {
            width: 100%;
        }

        .die-top-btn {
            flex: 1;
        }

        .die-form-grid {
            grid-template-columns: 1fr;
        }

        .die-form-group.full {
            grid-column: auto;
        }

        .die-product-info.active {
            grid-template-columns: repeat(2, 1fr);
        }

    }


    @media (max-width: 600px) {

        .die-page {
            padding: 10px 0 30px;
        }

        .die-container {
            border-radius: 20px;
            padding: 25px 15px 35px;
        }

        .die-title-area {
            gap: 10px;
        }

        .die-title-icon {
            width: 36px;
            height: 36px;
            font-size: 32px;
        }

        .die-title {
            font-size: 26px;
        }

        .die-header-actions {
            flex-direction: column;
        }

        .die-top-btn {
            width: 100%;
        }

        .die-table-wrapper {
            margin-top: 25px;
            border-radius: 16px;
        }

        .die-modal {
            padding: 10px;
        }

        .die-modal-card {
            border-radius: 18px;
        }

        .die-product-info.active {
            grid-template-columns: 1fr;
        }

        .die-form-footer {
            flex-direction: column-reverse;
        }

        .die-form-btn {
            width: 100%;
        }

    }


    /* =========================================================
       PRINT
    ========================================================= */

    @media print {

        .die-page {
            background: #ffffff;
            padding: 0;
        }

        .die-container {
            box-shadow: none;
            border-radius: 0;
            padding: 15px;
        }

        .die-header-actions,
        .die-actions,
        .die-modal {
            display: none !important;
        }

        .die-table-wrapper {
            margin-top: 20px;
        }

        .die-table th,
        .die-table td {
            height: 45px;
        }

    }

</style>


<div class="die-page">

    <div class="die-container">

        

        <div class="die-header">

            <div class="die-title-area">

                <div class="die-title-icon">
                    <i class="fas fa-scissors"></i>
                </div>

                <h1 class="die-title">
                    Dielines Cut Out
                </h1>

            </div>


            <div class="die-header-actions">

                <button type="button"
                        class="die-top-btn die-print-btn"
                        onclick="window.print()">

                    <i class="fas fa-print"></i>

                    Print

                </button>


                <button type="button"
                        class="die-top-btn die-new-btn"
                        onclick="openDieModal('create')">

                    <i class="fas fa-plus-circle"></i>

                    New Die

                </button>


                <button type="button"
                        class="die-top-btn die-add-btn"
                        onclick="openDieModal('create')">

                    <i class="fas fa-pen-to-square"></i>

                    Add / Edit

                </button>

            </div>

        </div>


        

        <?php if(session('success')): ?>

            <div class="die-alert die-alert-success">

                <i class="fas fa-circle-check"></i>

                <span>
                    <?php echo e(session('success')); ?>

                </span>

            </div>

        <?php endif; ?>


        <?php if($errors->any()): ?>

            <div class="die-alert die-alert-danger">

                <i class="fas fa-circle-exclamation"></i>

                <div>
                    <?php echo e($errors->first()); ?>

                </div>

            </div>

        <?php endif; ?>


        

        <div class="die-table-wrapper">

            <div class="die-table-scroll">

                <table class="die-table">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Item Name</th>

                            <th>Size</th>

                            <th>Rate</th>

                            <th>Up</th>

                            <th>Type</th>

                            <th>Repeat Date</th>

                            <th>Repairs</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $dies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $die): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <tr>

                            
                            <td>
                                <?php echo e($index + 1); ?>

                            </td>


                            
                            <td>

                                <span class="die-item-name">

                                    <?php echo e($die->product?->items?->item_code); ?>


                                </span>

                                <span class="die-product-id">

                                    Product #<?php echo e($die->product_id); ?>


                                </span>

                            </td>


                            
                            <td>

                                <span class="die-size">

                                    <?php echo e((round($die->length,2)) ?? '—'); ?>

                                    ×
                                    <?php echo e((round($die->width,2)) ?? '—'); ?>


                                </span>

                            </td>


                            
                            <td>

                                <span class="die-rate">

                                    <?php echo e($die->rate ?? '—'); ?>


                                </span>

                            </td>


                            
                            <td>

                                <span class="die-up">

                                    <?php echo e($die->ups ?? '—'); ?>


                                </span>

                            </td>


                            
                            <td>

                                <span class="die-type-badge die-type-new">

                                    New

                                </span>

                            </td>


                            
                            <td>

                                <span class="die-repeat-date">
                                    <?php echo e($die->repeat_date ?? '—'); ?>

                                </span>

                            </td>


                            
                            <td>

                                <span class="die-empty-value">
                                <?php echo e($die->repair_count>0? $die->repair_count>0 : '—'); ?>

                                </span>

                            </td>


                            
                            <td>

                                <div class="die-actions">


                                    
                                    <button type="button"
                                            class="die-action-btn die-view-btn"
                                            title="View"
                                            onclick="viewDie(
                                                <?php echo e($die->id); ?>

                                            )">

                                        <i class="fas fa-eye"></i>

                                    </button>


                                    
                                    <button type="button"
                                            class="die-action-btn die-edit-btn"
                                            title="Edit"
                                            onclick="editDie(
                                                <?php echo e($die->id); ?>,
                                                <?php echo e($die->product_id); ?>

                                            )">

                                        <i class="fas fa-pen"></i>

                                    </button>


                                    
                                    <button type="button"
                                            class="die-action-btn die-repeat-btn"
                                            title="Repeat"
                                            onclick="repeatDie(
                                                <?php echo e($die->id); ?>

                                            )">

                                        <i class="fas fa-rotate-right"></i>

                                    </button>


                                    
                                    <button type="button"
                                            class="die-action-btn die-repair-btn"
                                            title="Repair"
                                            onclick="repairDie(
                                                <?php echo e($die->id); ?>

                                            )">

                                        <i class="fas fa-screwdriver-wrench"></i>

                                    </button>


                                    
                                    <form action="<?php echo e(route('dies.destroy', $die)); ?>"
                                          method="POST"
                                          style="display:inline;"
                                          onsubmit="return confirmDelete();">

                                        <?php echo csrf_field(); ?>

                                        <?php echo method_field('DELETE'); ?>

                                        <button type="submit"
                                                class="die-action-btn die-delete-btn"
                                                title="Delete">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <tr>

                            <td colspan="9"
                                class="die-empty-row">

                                <div class="die-empty-icon">

                                    <i class="fas fa-scissors"></i>

                                </div>

                                <h3 class="die-empty-title">

                                    No Dies Found

                                </h3>

                                <p class="die-empty-text">

                                    Click "New Die" to create your first die.

                                </p>

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>





<div class="die-modal"
     id="dieModal">

    <div class="die-modal-card">


        
        <div class="die-modal-header">

            <div class="die-modal-title">

                <div class="die-modal-title-icon">

                    <i class="fas fa-scissors"></i>

                </div>

                <div>

                    <h3 id="dieModalTitle">
                        Add New Die
                    </h3>

                    <p>
                        Select a registered product
                    </p>

                </div>

            </div>


            <button type="button"
                    class="die-modal-close"
                    onclick="closeDieModal()">

                <i class="fas fa-times"></i>

            </button>

        </div>



        
        <form method="POST"
              id="dieForm"
              action="<?php echo e(route('dies.store')); ?>">

            <?php echo csrf_field(); ?>

            <input type="hidden"
                   name="_method"
                   id="dieFormMethod"
                   value="POST">


            <div class="die-form">

                <div class="die-form-grid">


                    
                    <div class="die-form-group full">

                        <label class="die-form-label">

                            Product
                            <span class="die-required">*</span>

                        </label>


                        <select name="product_id"
                                id="dieProduct"
                                class="die-form-control select2"
                                data-toggle="select2"
                                required>

                            <option value="">
                                Select Product
                            </option>

                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($product->id); ?>"
                                        data-item="<?php echo e($product->items?->item_code); ?>"
                                        data-length="<?php echo e($product->length); ?>"
                                        data-width="<?php echo e($product->width); ?>"
                                        data-ups="<?php echo e($product->ups); ?>">

                                    <?php echo e($product->prod_name); ?>


                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                    </div>



                    
                    <div class="die-product-info"
                         id="dieProductInfo">


                        <div>

                            <div class="die-info-label">
                                Item Name
                            </div>

                            <div class="die-info-value"
                                 id="infoItemName">
                                —
                            </div>

                        </div>


                        <div>

                            <div class="die-info-label">
                                Length
                            </div>

                            <div class="die-info-value"
                                 id="infoLength">
                                —
                            </div>

                        </div>


                        <div>

                            <div class="die-info-label">
                                Width
                            </div>

                            <div class="die-info-value"
                                 id="infoWidth">
                                —
                            </div>

                        </div>


                        <div>

                            <div class="die-info-label">
                                No. of Ups
                            </div>

                            <div class="die-info-value"
                                 id="infoUps">
                                —
                            </div>

                        </div>

                    </div>



                    
                    <div class="die-form-group">

                        <label class="die-form-label">
                            Item Name
                        </label>

                        <input type="text"
                               id="dieItemName"
                               class="die-form-control"
                               readonly>

                    </div>



                    
                    <div class="die-form-group">

                        <label class="die-form-label">
                            Length
                        </label>

                        <input type="text"
                               id="dieLength"
                               class="die-form-control"
                               readonly>

                    </div>



                    
                    <div class="die-form-group">

                        <label class="die-form-label">
                            Width
                        </label>

                        <input type="text"
                               id="dieWidth"
                               class="die-form-control"
                               readonly>

                    </div>



                    
                    <div class="die-form-group">

                        <label class="die-form-label">
                            No. of Ups
                        </label>

                        <input type="text"
                               id="dieUps"
                               class="die-form-control"
                               readonly>

                    </div>
                    <div class="die-form-group">

    <label class="die-form-label">
        Rate
        <span class="die-required">*</span>
    </label>

    <input type="number"
           name="rate"
           id="dieRate"
           class="die-form-control"
           step="0.01"
           min="0"
           placeholder="Enter die rate"
           required>

</div>
                    
          <div class="die-form-group">

    <label class="die-form-label">
        Type
        <span class="die-required">*</span>
    </label>

    <select name="type"
            id="dieType"
            class="die-form-control"
            required>

        <option value="new">
            New
        </option>

        <option value="repair">
            Repair
        </option>

        <option value="repeat">
            Repeat
        </option>

    </select>

</div>

                </div>

<div class="die-form-group"
     id="repeatDateGroup"
     style="display: none;">

    <label class="die-form-label">
        Repeat Date
    </label>

    <input type="date"
           name="repeat_date"
           id="dieRepeatDate"
           class="die-form-control">
           <input type="hidden"
       name="repair_count"
       id="dieRepairCount"
       value="0">

</div>
<div class="die-form-group full">

    <label class="die-form-label">
        Description
    </label>

    <textarea name="description"
              id="dieDescription"
              class="die-form-control"
              rows="4"
              placeholder="Enter die description..."
              style="height: auto; padding: 12px 13px; resize: vertical;"></textarea>

</div>





                
                <div class="die-form-footer">

                    <button type="button"
                            class="die-form-btn die-cancel-btn"
                            onclick="closeDieModal()">

                        Cancel

                    </button>


                    <button type="submit"
                            class="die-form-btn die-submit-btn">

                        <i class="fas fa-save"></i>

                        <span id="dieSubmitText">
                            Save Die
                        </span>

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>



<div class="die-modal"
     id="repairDieModal">

    <div class="die-modal-card">

        
        <div class="die-modal-header">

            <div class="die-modal-title">

                <div class="die-modal-title-icon"
                     style="background:#eee7ff;color:#733cff;">

                    <i class="fas fa-screwdriver-wrench"></i>

                </div>

                <div>

                    <h3>
                        Repair Die
                    </h3>

                    <p>
                        Record a repair for this die
                    </p>

                </div>

            </div>


            <button type="button"
                    class="die-modal-close"
                    onclick="closeRepairDieModal()">

                <i class="fas fa-times"></i>

            </button>

        </div>


        
        <form method="POST"
              id="repairDieForm"
              action="<?php echo e(route('dies.repair.store')); ?>">

            <?php echo csrf_field(); ?>

            <input type="hidden"
                   name="die_id"
                   id="repairDieId">


            <div class="die-form">

                <div class="die-form-grid">


                    
                    <div class="die-form-group full">

                        <label class="die-form-label">
                            Item Name
                        </label>

                        <input type="text"
                               id="repairItemName"
                               class="die-form-control"
                               readonly>

                    </div>


                    
                    <div class="die-form-group">

                        <label class="die-form-label">
                            Length
                        </label>

                        <input type="text"
                               id="repairLength"
                               class="die-form-control"
                               readonly>

                    </div>


                    
                    <div class="die-form-group">

                        <label class="die-form-label">
                            Width
                        </label>

                        <input type="text"
                               id="repairWidth"
                               class="die-form-control"
                               readonly>

                    </div>


                    
                    <div class="die-form-group">

                        <label class="die-form-label">
                            Current Repair Count
                        </label>

                        <input type="number"
                               id="repairCurrentCount"
                               class="die-form-control"
                               readonly>

                    </div>


                    
                    <div class="die-form-group">

                        <label class="die-form-label">
                            Repair Date
                            <span class="die-required">*</span>
                        </label>

                        <input type="date"
                               name="repair_date"
                               id="repairDate"
                               class="die-form-control"
                               value="<?php echo e(date('Y-m-d')); ?>"
                               required>

                    </div>


                    
                    <div class="die-form-group full">

                        <label class="die-form-label">
                            Repair Description
                        </label>

                        <textarea name="description"
                                  id="repairDescription"
                                  class="die-form-control"
                                  rows="4"
                                  style="height:auto;padding:12px 13px;resize:vertical;"
                                  placeholder="Enter repair details..."></textarea>

                    </div>


                </div>


                
                <div class="die-form-footer">

                    <button type="button"
                            class="die-form-btn die-cancel-btn"
                            onclick="closeRepairDieModal()">

                        Cancel

                    </button>


                    <button type="submit"
                            class="die-form-btn"
                            style="background:#733cff;color:#fff;">

                        <i class="fas fa-screwdriver-wrench"></i>

                        Record Repair

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<script>

$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | INITIALIZE SELECT2
    |--------------------------------------------------------------------------
    */

    $('#dieProduct').select2({
        placeholder: 'Select Product',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#dieModal')
    });


    /*
    |--------------------------------------------------------------------------
    | PRODUCT CHANGE EVENT
    |--------------------------------------------------------------------------
    */

    $('#dieProduct').on('change', function () {

        populateProductData();

    });


    /*
    |--------------------------------------------------------------------------
    | POPULATE PRODUCT DATA
    |--------------------------------------------------------------------------
    */

    function populateProductData() {

        let selectedOption = $('#dieProduct option:selected');

        let productId = $('#dieProduct').val();


        /*
        |--------------------------------------------------------------------------
        | NO PRODUCT SELECTED
        |--------------------------------------------------------------------------
        */

        if (!productId) {

            $('#dieItemName').val('');
            $('#dieLength').val('');
            $('#dieWidth').val('');
            $('#dieUps').val('');

            $('#infoItemName').text('—');
            $('#infoLength').text('—');
            $('#infoWidth').text('—');
            $('#infoUps').text('—');

            $('#dieProductInfo').removeClass('active');

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | GET DATA ATTRIBUTES
        |--------------------------------------------------------------------------
        */

        let item =
            selectedOption.attr('data-item') || '';

        let length =
            selectedOption.attr('data-length') || '';

        let width =
            selectedOption.attr('data-width') || '';

        let ups =
            selectedOption.attr('data-ups') || '';


        /*
        |--------------------------------------------------------------------------
        | DEBUG
        |--------------------------------------------------------------------------
        */

        console.log('Selected Product:', productId);

        console.log('Item:', item);
        console.log('Length:', length);
        console.log('Width:', width);
        console.log('Ups:', ups);


        /*
        |--------------------------------------------------------------------------
        | FORM FIELDS
        |--------------------------------------------------------------------------
        */

        $('#dieItemName').val(item);

        $('#dieLength').val(length);

        $('#dieWidth').val(width);

        $('#dieUps').val(ups);


        /*
        |--------------------------------------------------------------------------
        | PRODUCT INFORMATION BOX
        |--------------------------------------------------------------------------
        */

        $('#infoItemName').text(item || '—');

        $('#infoLength').text(length || '—');

        $('#infoWidth').text(width || '—');

        $('#infoUps').text(ups || '—');


        /*
        |--------------------------------------------------------------------------
        | SHOW PRODUCT INFORMATION
        |--------------------------------------------------------------------------
        */

        $('#dieProductInfo').addClass('active');

    }

   /*
|--------------------------------------------------------------------------
| TYPE CHANGE
|--------------------------------------------------------------------------
*/

function handleDieType() {

    let type = $('#dieType').val();

    if (type === 'repeat') {

        $('#repeatDateGroup').show();

        $('#dieRepeatDate')
            .prop('required', true);

    } else {

        $('#repeatDateGroup').hide();

        $('#dieRepeatDate')
            .prop('required', false)
            .val('');

    }
}


/*
|--------------------------------------------------------------------------
| WHEN TYPE CHANGES
|--------------------------------------------------------------------------
*/

$('#dieType').on('change', function () {

    handleDieType();

});


/*
|--------------------------------------------------------------------------
| INITIAL STATE
|--------------------------------------------------------------------------
*/

handleDieType();

    /*
    |--------------------------------------------------------------------------
    | OPEN CREATE MODAL
    |--------------------------------------------------------------------------
    */

    window.openDieModal = function(mode = 'create') {

        $('#dieModal').addClass('active');

        $('body').css('overflow', 'hidden');


        if (mode === 'create') {

            /*
            |--------------------------------------------------------------------------
            | RESET FORM
            |--------------------------------------------------------------------------
            */

            $('#dieForm')[0].reset();


            /*
            |--------------------------------------------------------------------------
            | RESET SELECT2
            |--------------------------------------------------------------------------
            */

            $('#dieProduct')
                .val(null)
                .trigger('change');


            /*
            |--------------------------------------------------------------------------
            | FORM ACTION
            |--------------------------------------------------------------------------
            */

            $('#dieForm').attr(
                'action',
                "<?php echo e(route('dies.store')); ?>"
            );


            $('#dieFormMethod').val('POST');


            /*
            |--------------------------------------------------------------------------
            | MODAL TEXT
            |--------------------------------------------------------------------------
            */

            $('#dieModalTitle').text('Add New Die');

            $('#dieSubmitText').text('Save Die');


            /*
            |--------------------------------------------------------------------------
            | HIDE PRODUCT INFO
            |--------------------------------------------------------------------------
            */

            $('#dieProductInfo').removeClass('active');

        }

    };


    /*
    |--------------------------------------------------------------------------
    | CLOSE MODAL
    |--------------------------------------------------------------------------
    */

    window.closeDieModal = function() {

        $('#dieModal').removeClass('active');

        $('body').css('overflow', '');

    };


    /*
    |--------------------------------------------------------------------------
    | EDIT DIE
    |--------------------------------------------------------------------------
    */

    window.editDie = function(id, productId) {

        /*
        |--------------------------------------------------------------------------
        | FORM ACTION
        |--------------------------------------------------------------------------
        */

        $('#dieForm').attr(
            'action',
            "<?php echo e(url('dies')); ?>/" + id
        );


        /*
        |--------------------------------------------------------------------------
        | METHOD
        |--------------------------------------------------------------------------
        */

        $('#dieFormMethod').val('PUT');


        /*
        |--------------------------------------------------------------------------
        | MODAL TEXT
        |--------------------------------------------------------------------------
        */

        $('#dieModalTitle').text('Edit Die');

        $('#dieSubmitText').text('Update Die');


        /*
        |--------------------------------------------------------------------------
        | SET PRODUCT
        |--------------------------------------------------------------------------
        */

        $('#dieProduct')
            .val(productId)
            .trigger('change');


        /*
        |--------------------------------------------------------------------------
        | OPEN MODAL
        |--------------------------------------------------------------------------
        */

        $('#dieModal').addClass('active');

        $('body').css('overflow', 'hidden');

    };


    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    window.viewDie = function(id) {

        alert("shdbx");

    };
function repairDie(id) {

    fetch("<?php echo e(url('dies')); ?>/" + id + "/repair-data")
        .then(response => {

            if (!response.ok) {
                throw new Error('Failed to load die data.');
            }

            return response.json();

        })
        .then(data => {

            $('#repairDieId').val(data.id);

            $('#repairItemName').val(data.item_name || '');

            $('#repairLength').val(data.length || '');

            $('#repairWidth').val(data.width || '');

            $('#repairCurrentCount').val(
                data.repair_count ?? 0
            );

            $('#repairDescription').val('');

            $('#repairDate').val(
                new Date().toISOString().split('T')[0]
            );

            $('#repairDieModal')
                .addClass('active');

            document.body.style.overflow = 'hidden';

        })
        .catch(error => {

            console.error(error);

            alert(
                'Unable to load die information.'
            );

        });

}
function closeRepairDieModal() {

    $('#repairDieModal')
        .removeClass('active');

    document.body.style.overflow = '';

}


    /*
    |--------------------------------------------------------------------------
    | REPEAT
    |--------------------------------------------------------------------------
    */

    window.repeatDie = function(id) {

        alert('Repeat Die #' + id);

    };


    /*
    |--------------------------------------------------------------------------
    | REPAIR
    |--------------------------------------------------------------------------
    */

    window.repairDie = function(id) {

        repairDie(id);

    };


    /*
    |--------------------------------------------------------------------------
    | DELETE CONFIRMATION
    |--------------------------------------------------------------------------
    */

    window.confirmDelete = function() {

        return confirm(
            'Are you sure you want to delete this die?'
        );

    };


    /*
    |--------------------------------------------------------------------------
    | CLOSE MODAL BY BACKDROP
    |--------------------------------------------------------------------------
    */

    $('#dieModal').on('click', function(event) {

        if (event.target === this) {

            closeDieModal();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | ESCAPE KEY
    |--------------------------------------------------------------------------
    */

    $(document).on('keydown', function(event) {

        if (event.key === 'Escape') {

            closeDieModal();

        }

    });

});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/dies/index.blade.php ENDPATH**/ ?>