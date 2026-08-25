

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
   VIEW / DETAIL MODAL
========================================================= */

.die-detail-modal {
    position: fixed;
    inset: 0;
    z-index: 10000;

    display: none;
    align-items: center;
    justify-content: center;

    padding: 20px;

    background: rgba(15, 27, 43, .48);
    backdrop-filter: blur(5px);
}

.die-detail-modal.active {
    display: flex;
}

.die-detail-card {
    width: 100%;
    max-width: 830px;
    max-height: 90vh;

    background: #ffffff;

    border-radius: 25px;

    box-shadow: 0 25px 70px rgba(15, 23, 42, .25);

    overflow: hidden;

    animation: dieDetailModalIn .22s ease;

    display: flex;
    flex-direction: column;
}

@keyframes dieDetailModalIn {

    from {
        opacity: 0;
        transform: translateY(15px) scale(.98);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

}


/* Header */

.die-detail-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 25px 30px 18px;

    flex-shrink: 0;
}

.die-detail-title {
    display: flex;
    align-items: center;
    gap: 14px;
}

.die-detail-title-icon {
    width: 40px;
    height: 40px;

    border-radius: 50%;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #2864e8;
    color: #ffffff;

    font-size: 19px;
}

.die-detail-title h3 {
    margin: 0;

    color: #102744;

    font-size: 24px;
    font-weight: 800;
}

.die-detail-close {
    width: 38px;
    height: 38px;

    border: none;
    background: transparent;

    color: #94a3b8;

    font-size: 22px;

    cursor: pointer;

    display: flex;
    align-items: center;
    justify-content: center;
}

.die-detail-close:hover {
    color: #475569;
}


/* Body */

.die-detail-body {
    padding: 0 30px 30px;

    overflow-y: auto;
}


/* Details grid */

.die-detail-grid {
    display: grid;

    grid-template-columns: 1fr 1fr;

    column-gap: 70px;
    row-gap: 24px;

    padding: 5px 0 25px;
}

.die-detail-item {
    min-width: 0;
}

.die-detail-label {
    margin-bottom: 4px;

    color: #71849a;

    font-size: 13px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: .5px;
}

.die-detail-value {
    color: #102744;

    font-size: 19px;
    font-weight: 500;
}

.die-detail-value.empty {
    color: #1f324b;
}


/* Type */

.die-detail-type {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    min-width: 80px;
    height: 30px;

    padding: 0 16px;

    border-radius: 18px;

    font-size: 14px;
    font-weight: 700;
}

.die-detail-type-new {
    background: #dceafe;
    color: #2864e8;
}

.die-detail-type-repair {
    background: #eee7ff;
    color: #733cff;
}

.die-detail-type-repeat {
    background: #fff0bd;
    color: #bc6900;
}


/* Divider */

.die-detail-divider {
    height: 1px;

    background: #e7edf3;

    margin: 0 0 22px;
}


/* Repair heading */

.die-repair-history-title {
    display: flex;
    align-items: center;

    gap: 11px;

    margin-bottom: 12px;
}

.die-repair-history-title i {
    color: #733cff;
    font-size: 19px;
}

.die-repair-history-title h4 {
    margin: 0;

    color: #243b58;

    font-size: 18px;
    font-weight: 700;
}


/* Repair history */

.die-repair-history {
    display: flex;
    flex-direction: column;

    gap: 12px;
}

.die-repair-history-item {
    padding: 13px 18px;

    background: #f7f9fc;

    border-left: 4px solid #733cff;

    border-radius: 14px;
}

.die-repair-history-date {
    display: flex;
    align-items: center;

    gap: 7px;

    margin-bottom: 6px;

    color: #733cff;

    font-size: 14px;
    font-weight: 700;
}

.die-repair-history-date i {
    font-size: 13px;
}

.die-repair-history-description {
    color: #243b58;

    font-size: 16px;
    line-height: 1.45;
}

.die-repair-history-description i {
    color: #a6b0bd;

    margin-right: 8px;

    font-size: 13px;
}


/* No history */

.die-no-repair-history {
    padding: 20px;

    text-align: center;

    border-radius: 12px;

    background: #f7f9fc;

    color: #8a99aa;

    font-size: 14px;
}


/* Description */

.die-detail-description {
    margin-top: 22px;
}

.die-detail-description-box {
    margin-top: 8px;

    padding: 13px 16px;

    border-radius: 12px;

    background: #f7f9fc;

    color: #344b66;

    font-size: 14px;

    line-height: 1.6;
}


/* Footer */

.die-detail-footer {
    display: flex;

    justify-content: flex-end;

    padding: 18px 30px 22px;

    border-top: 1px solid #e7edf3;

    flex-shrink: 0;
}

.die-detail-close-btn {
    height: 46px;

    padding: 0 28px;

    border: 1px solid #cbd8e7;

    border-radius: 24px;

    background: #ffffff;

    color: #344b66;

    font-size: 16px;
    font-weight: 700;

    cursor: pointer;
}

.die-detail-close-btn:hover {
    background: #f5f8fb;
}


/* Responsive */

@media (max-width: 700px) {

    .die-detail-card {
        max-height: 94vh;

        border-radius: 20px;
    }

    .die-detail-header {
        padding: 20px;
    }

    .die-detail-body {
        padding: 0 20px 25px;
    }

    .die-detail-grid {
        grid-template-columns: 1fr;

        row-gap: 18px;

        column-gap: 0;
    }

    .die-detail-footer {
        padding: 15px 20px 18px;
    }

    .die-detail-close-btn {
        width: 100%;
    }

}
/* ============================================================
   REPAIR DIE MODAL
============================================================= */

.repair-modal-card {
    width: 100%;
    max-width: 805px;

    background: #ffffff;

    border-radius: 28px;

    box-shadow:
        0 30px 80px rgba(15, 23, 42, 0.25);

    overflow: hidden;

    animation: repairModalIn .22s ease;
}


@keyframes repairModalIn {

    from {
        opacity: 0;
        transform: translateY(15px) scale(.98);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

}


/* ============================================================
   HEADER
============================================================= */

.repair-modal-header {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    padding: 28px 46px 10px;

}


.repair-modal-heading {

    display: flex;

    align-items: flex-start;

    gap: 15px;

}


.repair-modal-icon {

    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    color: #7c4dff;

    font-size: 30px;

    flex-shrink: 0;

}


.repair-modal-title {

    margin: 0;

    color: #16233b;

    font-size: 30px;

    line-height: 1.2;

    font-weight: 800;

    letter-spacing: -0.5px;
}


.repair-modal-subtitle {

    margin: 10px 0 0;

    color: #6d809c;

    font-size: 17px;

    line-height: 1.4;

}


.repair-modal-subtitle strong {

    color: #53657d;

    font-weight: 800;

}


.repair-modal-close {

    width: 38px;
    height: 38px;

    border: none;

    background: transparent;

    color: #91a1b7;

    font-size: 23px;

    cursor: pointer;

    display: flex;

    align-items: center;
    justify-content: center;

    transition: .18s ease;
}


.repair-modal-close:hover {

    color: #53657d;

    transform: scale(1.05);

}


/* ============================================================
   BODY
============================================================= */

.repair-modal-body {

    padding: 15px 46px 28px;

}


.repair-field-group {

    margin-top: 22px;

}


.repair-field-label {

    display: flex;

    align-items: center;

    gap: 10px;

    margin-bottom: 9px;

    color: #34445b;

    font-size: 17px;

    font-weight: 750;
}


.repair-field-label i {

    width: 20px;

    color: #687b95;

    font-size: 17px;

}


/* ============================================================
   DATE INPUT
============================================================= */

.repair-field-control {

    width: 100%;

    height: 60px;

    padding: 0 20px;

    border: 2px solid #d8e0ea;

    border-radius: 15px;

    background: #ffffff;

    color: #26354c;

    font-size: 18px;

    outline: none;

    transition: all .18s ease;
}


.repair-field-control:focus {

    border-color: #9a70f7;

    box-shadow:
        0 0 0 3px rgba(124, 77, 255, .08);
}


/* ============================================================
   CHECKBOXES
============================================================= */

.repair-checkbox-row {

    display: flex;

    align-items: center;

    flex-wrap: wrap;

    gap: 27px;

    padding-top: 2px;
}


.repair-checkbox-item {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    color: #37455a;

    font-size: 17px;

    cursor: pointer;

    user-select: none;
}


.repair-checkbox-item input {

    position: absolute;

    opacity: 0;

    pointer-events: none;
}


.repair-custom-checkbox {

    width: 23px;
    height: 23px;

    border: 2px solid #8793a2;

    border-radius: 4px;

    background: #ffffff;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    transition: all .18s ease;

    flex-shrink: 0;
}


.repair-checkbox-item input:checked
+ .repair-custom-checkbox {

    background: #8755ed;

    border-color: #8755ed;
}


.repair-checkbox-item input:checked
+ .repair-custom-checkbox::after {

    content: "\f00c";

    font-family: "Font Awesome 6 Free";

    font-weight: 900;

    color: #ffffff;

    font-size: 13px;
}


/* ============================================================
   DESCRIPTION
============================================================= */

.repair-description-control {

    width: 100%;

    min-height: 100px;

    padding: 14px 20px;

    border: 2px solid #d8e0ea;

    border-radius: 15px;

    background: #ffffff;

    color: #26354c;

    font-size: 17px;

    line-height: 1.5;

    resize: vertical;

    outline: none;

    font-family: inherit;

    transition: all .18s ease;
}


.repair-description-control::placeholder {

    color: #8c8f96;
}


.repair-description-control:focus {

    border-color: #9a70f7;

    box-shadow:
        0 0 0 3px rgba(124, 77, 255, .08);
}


/* ============================================================
   FOOTER
============================================================= */

.repair-modal-footer {

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 14px;

    margin-top: 28px;

    padding-top: 27px;

    border-top: 1px solid #e8edf3;
}


.repair-cancel-btn {

    min-width: 130px;

    height: 56px;

    padding: 0 28px;

    border: 2px solid #d2ddea;

    border-radius: 30px;

    background: #ffffff;

    color: #52627a;

    font-size: 17px;

    font-weight: 750;

    cursor: pointer;

    transition: all .18s ease;
}


.repair-cancel-btn:hover {

    background: #f7f9fc;

    border-color: #bdc9d8;
}


.repair-save-btn {

    min-width: 210px;

    height: 56px;

    padding: 0 28px;

    border: none;

    border-radius: 30px;

    background: #8755ed;

    color: #ffffff;

    font-size: 17px;

    font-weight: 750;

    cursor: pointer;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 10px;

    box-shadow:
        0 8px 18px rgba(135, 85, 237, .22);

    transition: all .18s ease;
}


.repair-save-btn:hover {

    background: #7542dc;

    transform: translateY(-1px);

    box-shadow:
        0 10px 22px rgba(135, 85, 237, .28);
}


/* ============================================================
   MOBILE
============================================================= */

@media (max-width: 700px) {

    .repair-modal-card {

        max-width: 100%;

        border-radius: 22px;

    }


    .repair-modal-header {

        padding: 22px 24px 8px;

    }


    .repair-modal-body {

        padding: 12px 24px 24px;

    }


    .repair-modal-title {

        font-size: 25px;

    }


    .repair-modal-subtitle {

        font-size: 14px;

    }


    .repair-checkbox-row {

        flex-direction: column;

        align-items: flex-start;

        gap: 14px;

    }


    .repair-modal-footer {

        flex-direction: column-reverse;

    }


    .repair-cancel-btn,
    .repair-save-btn {

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
    /* =========================================================
   REPAIR MODAL
========================================================= */

.repair-modal-card {
    max-width: 760px;
    max-height: 90vh;
    overflow-y: auto;
}


/* =========================================================
   REPAIR TYPES
========================================================= */

.repair-type-options {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    padding-top: 3px;
}

.repair-check {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    color: #344b66;
    font-size: 14px;
    cursor: pointer;
}

.repair-check input {
    width: 21px;
    height: 21px;

    accent-color: #733cff;

    cursor: pointer;
}


/* =========================================================
   REPAIR SAVE BUTTON
========================================================= */

.repair-save-btn {
    background: #733cff;
    color: #ffffff;
}

.repair-save-btn:hover {
    background: #6330e5;
}


/* =========================================================
   REPAIR HISTORY
========================================================= */

.repair-history-section {

    margin-top: 28px;

    padding-top: 22px;

    border-top: 1px solid #e5eaf0;
}


.repair-history-header {

    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-bottom: 14px;
}


.repair-history-title {

    display: flex;
    align-items: center;

    gap: 9px;

    color: #34445c;

    font-size: 16px;
    font-weight: 750;
}


.repair-history-title i {

    color: #733cff;

    font-size: 17px;
}


.repair-history-count {

    min-width: 28px;
    height: 28px;

    padding: 0 9px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 15px;

    background: #eee7ff;
    color: #733cff;

    font-size: 12px;
    font-weight: 800;
}


.repair-history-list {

    display: flex;

    flex-direction: column;

    gap: 10px;

    max-height: 250px;

    overflow-y: auto;

    padding-right: 3px;
}


/* =========================================================
   HISTORY ITEM
========================================================= */

.repair-history-item {

    padding: 14px 16px;

    border-left: 4px solid #8b5cf6;

    border-radius: 10px;

    background: #f7f9fc;
}


.repair-history-date {

    display: flex;

    align-items: center;

    gap: 7px;

    color: #733cff;

    font-size: 13px;

    font-weight: 750;

    margin-bottom: 8px;
}


.repair-history-date i {

    font-size: 12px;
}


.repair-history-types {

    display: flex;

    flex-wrap: wrap;

    gap: 6px;

    margin-bottom: 7px;
}


.repair-history-type {

    display: inline-flex;

    align-items: center;

    padding: 4px 9px;

    border-radius: 12px;

    background: #eee7ff;

    color: #6534d7;

    font-size: 11px;

    font-weight: 700;
}


.repair-history-description {

    color: #34445c;

    font-size: 13px;

    line-height: 1.5;
}


.repair-history-description.empty {

    color: #94a3b8;

    font-style: italic;
}


.repair-history-loading,
.repair-history-empty {

    padding: 25px;

    text-align: center;

    border-radius: 12px;

    background: #f7f9fc;

    color: #8796a8;

    font-size: 13px;
}


.repair-history-loading i {

    margin-right: 7px;

    color: #733cff;
}


/* Mobile */

@media (max-width: 600px) {

    .repair-type-options {
        flex-direction: column;
        gap: 12px;
    }

    .repair-modal-card {
        max-height: 95vh;
    }

}

/* ============================================================
   UNIFIED DIE MODAL
   Add / Edit / Repair / Repeat
============================================================ */

.die-modal {
    position: fixed;
    inset: 0;

    z-index: 10000;

    display: none;
    align-items: center;
    justify-content: center;

    padding: 20px;

    background: rgba(15, 27, 43, .48);
    backdrop-filter: blur(5px);

    overflow-y: auto;
}

.die-modal.active {
    display: flex;
}

.die-modal-card {
    width: 100%;
    max-width: 830px;
    max-height: 90vh;

    background: #ffffff;

    border-radius: 25px;

    box-shadow:
        0 25px 70px rgba(15, 23, 42, .25);

    overflow-y: auto;

    animation: dieDetailModalIn .22s ease;
}

.die-modal-card.repair-modal-card {
    max-width: 830px;
}

@media (max-width: 700px) {

    .die-modal {
        padding: 10px;
    }

    .die-modal-card,
    .die-modal-card.repair-modal-card {
        max-width: 100%;
        max-height: 94vh;
        border-radius: 20px;
    }
}
.die-detail-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.die-detail-print-btn {
    height: 40px;
    padding: 0 18px;
    border: none;
    border-radius: 20px;
    background: #2864e8;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: .2s ease;
}

.die-detail-print-btn:hover {
    background: #1e54cb;
    transform: translateY(-1px);
}
/* =========================================================
   REPEAT DIE
========================================================= */

.die-repeat-submit-btn {
    background: #b85d00;
    color: #ffffff;
}

.die-repeat-submit-btn:hover {
    background: #9f4f00;
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


                <!-- <button type="button"
                        class="die-top-btn die-add-btn"
                        onclick="openDieModal('create')">

                    <i class="fas fa-pen-to-square"></i>

                    Add / Edit

                </button> -->

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

                            <th> Name</th>

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

                                    <?php echo e($die->product?->prod_name); ?>


                                </span>

                                <!-- <span class="die-product-id">

                                    Product #<?php echo e($die->product_id); ?>


                                </span> -->

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

                                    <?php echo e($die->no_of_ups ?? '—'); ?>


                                </span>

                            </td>


                            
                            <td>

                                <span class="die-type-badge die-type-new">

                                    <?php echo e($die->type ?? 'New'); ?>


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
        data-id="<?php echo e($die->id); ?>"
        data-die-code="<?php echo e($die->die_code); ?>"
        data-product-id="<?php echo e($die->product_id); ?>"
        data-rate="<?php echo e($die->rate); ?>"
        data-type="<?php echo e($die->type); ?>"
        data-repeat-date="<?php echo e($die->repeat_date); ?>"
        data-description="<?php echo e($die->description); ?>"
        data-repair-count="<?php echo e($die->repair_count ?? 0); ?>"
        onclick="editDie(this)">

    <i class="fas fa-pen"></i>

</button>



                                    

 <button type="button"
        class="die-action-btn die-repeat-btn"
        title="Repeat"
        onclick="openRepeatDieModal(<?php echo e($die->id); ?>)">

    <i class="fas fa-rotate-right"></i>

</button>


                                
<button type="button"
        class="die-action-btn die-repair-btn"
        title="Repair"
        data-id="<?php echo e($die->id); ?>"
        data-item_name="<?php echo e($die->product?->items?->item_code); ?>"
        data-length="<?php echo e($die->length); ?>"
        data-width="<?php echo e($die->width); ?>"
        data-repair-count="<?php echo e($die->repair_count ?? 0); ?>"
        onclick="repairDie(this)">

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

<div class="die-form-group">

    <label class="die-form-label">
        Die Code
        <span class="die-required">*</span>
    </label>

    <input type="text"
           name="die_code"
           id="dieCode"
           class="die-form-control"
           placeholder="Enter die code"
           required>

</div>

                    
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
                                        data-itemId="<?php echo e($product->item_id); ?>"
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


                        <!-- <div>

                            <div class="die-info-label">
                                Item Name
                            </div>

                            <div class="die-info-value"
                                 id="infoItemName">
                                —
                            </div>

                        </div> -->


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



                    
                    <!-- <div class="die-form-group">

                        <label class="die-form-label">
                            Item Name
                        </label>

                        <input type="text"
                               id="dieItemName"
                               class="die-form-control"
                               readonly>

                    </div> -->



                    
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

    <div class="die-modal-card repair-modal-card">

        
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
                        Record repair details for
                        <strong id="repairItemNameText">
                            —
                        </strong>
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

                            <i class="fas fa-calendar-days"></i>
                            Repair Date

                            <span class="die-required">*</span>

                        </label>

                        <input type="date"
                               name="repair_date"
                               id="repairDate"
                               class="die-form-control"
                               required>

                    </div>


                    
                    <div class="die-form-group full">

                        <label class="die-form-label">

                            <i class="fas fa-screwdriver-wrench"></i>

                            What is being repaired?

                        </label>


                        <div class="repair-type-options">

                            <label class="repair-check">

                                <input type="checkbox"
                                       name="repair_types[]"
                                       value="Blade rule change">

                                <span>
                                    Blade rule change
                                </span>

                            </label>


                            <label class="repair-check">

                                <input type="checkbox"
                                       name="repair_types[]"
                                       value="Crease rule">

                                <span>
                                    Crease rule
                                </span>

                            </label>


                            <label class="repair-check">

                                <input type="checkbox"
                                       name="repair_types[]"
                                       value="Wood ply">

                                <span>
                                    Wood ply
                                </span>

                            </label>


                            <label class="repair-check">

                                <input type="checkbox"
                                       name="repair_types[]"
                                       value="Other">

                                <span>
                                    Other
                                </span>

                            </label>

                        </div>

                    </div>


                    
                    <div class="die-form-group full">

                        <label class="die-form-label">

                            <i class="fas fa-align-left"></i>

                            Description / Details

                        </label>

                        <textarea name="description"
                                  id="repairDescription"
                                  class="die-form-control"
                                  rows="4"
                                  placeholder="Describe what was repaired, which parts were changed, etc."
                                  style="height:auto;padding:12px 13px;resize:vertical;"></textarea>

                    </div>


                </div>


                

                <div class="repair-history-section">

                    <div class="repair-history-header">

                        <div class="repair-history-title">

                            <i class="fas fa-clock-rotate-left"></i>

                            <span>
                                Previous Repairs
                            </span>

                        </div>

                        <span class="repair-history-count"
                              id="repairHistoryCount">
                            0
                        </span>

                    </div>


                    <div id="repairHistoryList"
                         class="repair-history-list">

                        <div class="repair-history-loading">

                            <i class="fas fa-spinner fa-spin"></i>

                            Loading repair history...

                        </div>

                    </div>

                </div>


                
                <div class="die-form-footer">

                    <button type="button"
                            class="die-form-btn die-cancel-btn"
                            onclick="closeRepairDieModal()">

                        Cancel

                    </button>


                    <button type="submit"
                            class="die-form-btn repair-save-btn">

                        <i class="fas fa-floppy-disk"></i>

                        Save Repair

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<div class="die-detail-modal"
     id="dieDetailModal">

    <div class="die-detail-card">

        
        <div class="die-detail-header">

            <div class="die-detail-title">

                <div class="die-detail-title-icon">
                    <i class="fas fa-eye"></i>
                </div>

                <div>

                    <h3>
                        Dieline Details
                    </h3>

                </div>

            </div>

     
    <div class="die-detail-header-actions">

        <button type="button"
                class="die-detail-print-btn"
                onclick="printDieView()">
            <i class="fas fa-print"></i>
            Print
        </button>

        <button type="button"
                class="die-detail-close"
                onclick="closeDieDetailModal()">
            <i class="fas fa-times"></i>
        </button>

    </div>

        </div>


        
        <div class="die-detail-body">

            <div class="die-detail-grid">

                
                <div class="die-detail-item">

                    <div class="die-detail-label">
                         Name
                    </div>

                    <div class="die-detail-value"
                         id="detailItemName">
                        —
                    </div>

                </div>


                
                <div class="die-detail-item">

                    <div class="die-detail-label">
                        Size
                    </div>

                    <div class="die-detail-value"
                         id="detailSize">
                        —
                    </div>

                </div>


                
                <div class="die-detail-item">

                    <div class="die-detail-label">
                        Rate
                    </div>

                    <div class="die-detail-value"
                         id="detailRate">
                        —
                    </div>

                </div>


                
                <div class="die-detail-item">

                    <div class="die-detail-label">
                        Up
                    </div>

                    <div class="die-detail-value"
                         id="detailUps">
                        —
                    </div>

                </div>


                
                <!-- <div class="die-detail-item">

                    <div class="die-detail-label">
                        Type
                    </div>

                    <div class="die-detail-value">

                        <span id="detailType"
                              class="die-detail-type die-detail-type-new">
                            New
                        </span>

                    </div>

                </div> -->


                
                <!-- <div class="die-detail-item">

                    <div class="die-detail-label">
                        Repeat Date
                    </div>

                    <div class="die-detail-value"
                         id="detailRepeatDate">
                        —
                    </div>

                </div> -->


                
                <div class="die-detail-item">

                    <div class="die-detail-label">
                        Total Repairs
                    </div>

                    <div class="die-detail-value"
                         id="detailRepairCount">
                        0
                    </div>

                </div>

            </div>


            
            <div class="die-detail-description"
                 id="detailDescriptionSection"
                 style="display:none;">

                <div class="die-detail-label">
                    Description
                </div>

                <div class="die-detail-description-box"
                     id="detailDescription">
                </div>

            </div>


            <div class="die-detail-divider"
                 style="margin-top:25px;">
            </div>


            
           <div class="die-repair-history-title">
    <i class="fas fa-screwdriver-wrench"></i>

    <h4>
        Repair History
    </h4>
</div>


            <div class="die-repair-history"
                 id="dieRepairHistory">

                

            </div>
            
            <div class="die-detail-divider"></div>

<div class="die-repair-history-title">

    <div class="die-repair-history-heading">

        <i class="fas fa-rotate-right"></i>

        <h4>
            Repeat History
        </h4>

    </div>

</div>

<div id="dieRepeatHistory"
     class="die-repair-history">

    

</div>

        </div>


        
        <div class="die-detail-footer">

            <button type="button"
                    class="die-detail-close-btn"
                    onclick="closeDieDetailModal()">

                Close

            </button>

        </div>

    </div>

</div>

<!-- Repeat Die Modal -->


<div id="repeatDieModal" class="die-modal">

    <div class="die-modal-card">

        
        <div class="die-modal-header">

            <div class="die-modal-title">

                <div class="die-modal-title-icon">
                    <i class="fas fa-rotate-right"></i>
                </div>

                <div>
                    <h3 id="repeatDieModalTitle">
                        Repeat Die
                    </h3>

                    <p>
                        Create repeat entry for this die
                    </p>
                </div>

            </div>

            <button type="button"
                    class="die-modal-close"
                    onclick="closeRepeatDieModal()">

                <i class="fas fa-times"></i>

            </button>

        </div>


        
        <form id="repeatDieForm"
              method="POST">

            <?php echo csrf_field(); ?>

            <div class="die-form">

                <div class="die-form-grid">


                    
                    <div class="die-form-group">

                        <label for="repeat_back_date"
                               class="die-form-label">

                            Back Date

                        </label>

                        <input type="date"
                               id="repeat_back_date"
                               name="back_date"
                               class="die-form-control"
                               >

                    </div>


                    
                    <div class="die-form-group">

                        <label for="repeat_date"
                               class="die-form-label">

                            Repeat Date

                            <span class="die-required">*</span>

                        </label>

                        <input type="date"
                               id="repeat_date"
                               name="repeat_date"
                               class="die-form-control"
                               required>

                    </div>


                    
                    <div class="die-form-group full">

                        <label for="repeat_description"
                               class="die-form-label">

                            Description

                            <span class="die-required">*</span>

                        </label>

                        <textarea id="repeat_description"
                                  name="description"
                                  class="die-form-control"
                                  rows="4"
                                  placeholder="Enter reason for repeating this die..."
                                  required></textarea>

                    </div>


                </div>


                
                <div class="die-form-footer">

                    <button type="button"
                            class="die-form-btn die-cancel-btn"
                            onclick="closeRepeatDieModal()">

                        Cancel

                    </button>


                    <button type="submit"
                            class="die-form-btn die-repeat-submit-btn">

                        <i class="fas fa-rotate-right"></i>

                        Repeat Die

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
        let itemId =
            selectedOption.attr('data-itemId') || '';
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

        console.log('Item:', itemId);
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
window.printDieView = function () {

    const dieView = document.getElementById('dieDetailModal');

    if (!dieView) {
        console.error('Die detail modal not found.');
        alert('Unable to print die details.');
        return;
    }

    const printWindow = window.open(
        '',
        '_blank',
        'width=1000,height=800'
    );

    if (!printWindow) {
        alert('Please allow popups in your browser to print.');
        return;
    }

    const content = dieView.querySelector('.die-detail-card');

    if (!content) {
        alert('Die details content not found.');
        printWindow.close();
        return;
    }

    printWindow.document.open();

    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>

            <meta charset="UTF-8">

            <title>Die Details</title>

            <link rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

            <style>

                * {
                    box-sizing: border-box;
                }

                html,
                body {
                    margin: 0;
                    padding: 0;
                    background: #ffffff;
                    color: #102744;
                    font-family: Arial, sans-serif;
                }

                body {
                    padding: 30px;
                }

                .die-detail-card {
                    width: 100%;
                    max-width: 850px;
                    margin: 0 auto;
                    background: #ffffff;
                }

                .die-detail-header {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 0 0 18px;
                    border-bottom: 2px solid #e7edf3;
                }

                .die-detail-title {
                    display: flex;
                    align-items: center;
                    gap: 14px;
                }

                .die-detail-title-icon {
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: #2864e8;
                    color: #ffffff;
                    font-size: 19px;
                }

                .die-detail-title h3 {
                    margin: 0;
                    color: #102744;
                    font-size: 24px;
                    font-weight: 800;
                }

                .die-detail-header-actions {
                    display: none !important;
                }

                .die-detail-body {
                    padding: 25px 0;
                    overflow: visible;
                }

                .die-detail-grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    column-gap: 70px;
                    row-gap: 24px;
                    padding: 5px 0 25px;
                }

                .die-detail-item {
                    min-width: 0;
                }

                .die-detail-label {
                    margin-bottom: 4px;
                    color: #71849a;
                    font-size: 13px;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: .5px;
                }

                .die-detail-value {
                    color: #102744;
                    font-size: 19px;
                    font-weight: 500;
                }

                .die-detail-divider {
                    height: 1px;
                    background: #e7edf3;
                    margin: 0 0 22px;
                }

                .die-repair-history-title {
                    display: flex;
                    align-items: center;
                    gap: 11px;
                    margin-bottom: 12px;
                }

                .die-repair-history-title i {
                    color: #733cff;
                    font-size: 19px;
                }

                .die-repair-history-title h4 {
                    margin: 0;
                    color: #243b58;
                    font-size: 18px;
                    font-weight: 700;
                }

                .die-repair-history-heading {
                    display: flex;
                    align-items: center;
                    gap: 11px;
                }

                .die-repair-history {
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                }

                .die-repair-history-item {
                    padding: 13px 18px;
                    background: #f7f9fc;
                    border-left: 4px solid #733cff;
                    border-radius: 14px;
                }

                .die-repair-history-date {
                    display: flex;
                    align-items: center;
                    gap: 7px;
                    margin-bottom: 6px;
                    color: #733cff;
                    font-size: 14px;
                    font-weight: 700;
                }

                .die-repair-history-description {
                    color: #243b58;
                    font-size: 16px;
                    line-height: 1.45;
                }

                .die-detail-description {
                    margin-top: 22px;
                }

                .die-detail-description-box {
                    margin-top: 8px;
                    padding: 13px 16px;
                    border-radius: 12px;
                    background: #f7f9fc;
                    color: #344b66;
                    font-size: 14px;
                    line-height: 1.6;
                }

                .die-detail-footer,
                .die-detail-close,
                button,
                .btn {
                    display: none !important;
                }

                @media print {

                    @page {
                        size: A4;
                        margin: 15mm;
                    }

                    body {
                        padding: 0;
                    }

                    .die-detail-card {
                        max-width: 100%;
                    }

                }

            </style>

        </head>

        <body>

            ${content.outerHTML}

        </body>
        </html>
    `);

    printWindow.document.close();

    printWindow.onload = function () {

        setTimeout(function () {

            printWindow.focus();

            printWindow.print();

            setTimeout(function () {
                printWindow.close();
            }, 500);

        }, 300);

    };

};


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
window.openRepeatDieModal = function (dieId) {

    const modal = $('#repeatDieModal');
    const form = $('#repeatDieForm');

    if (!modal.length || !form.length) {
        console.error('Repeat modal not found.');
        return;
    }

    // Form action
    form.attr(
        'action',
        "<?php echo e(url('dies')); ?>/" + dieId + "/repeat"
    );

    // Current date
    const today = new Date()
        .toISOString()
        .split('T')[0];

    $('#repeat_date').val(today);

    // Reset description
    $('#repeat_description').val('');

    // Open exactly like existing Die/Repair modal
    modal.addClass('active');

    $('body').css('overflow', 'hidden');


    // Get original die creation date
    fetch(
        "<?php echo e(url('dies')); ?>/" + dieId + "/repeat-info",
        {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }
    )
    .then(response => response.json())
    .then(data => {

        $('#repeat_back_date').val(
            data.back_date
        );

    })
    .catch(error => {

        console.error(
            'Repeat info error:',
            error
        );

    });
};


window.closeRepeatDieModal = function () {

    $('#repeatDieModal').removeClass('active');

    $('body').css('overflow', '');

};


window.openRepeatDieModal = function (dieId) {

    const modal = document.getElementById('repeatDieModal');
    const form = document.getElementById('repeatDieForm');

    console.log('Repeat clicked:', dieId);
    console.log('Modal:', modal);
    console.log('Form:', form);

    if (!modal || !form) {
        console.error('Repeat modal or form not found.');
        return;
    }

    // Set form action
    form.action = `/probox/dies/${dieId}/repeat`;

    // Current date
    const today = new Date().toISOString().split('T')[0];

    $('#repeat_date').val(today);

    // Clear description
    $('#repeat_description').val('');

    /*
    |--------------------------------------------------------------------------
    | Open modal IMMEDIATELY
    |--------------------------------------------------------------------------
    */

    modal.classList.add('active');

    $('body').css('overflow', 'hidden');

    /*
    |--------------------------------------------------------------------------
    | Load original die information
    |--------------------------------------------------------------------------
    */

    fetch(`/probox/dies/${dieId}/repeat-info`)
        .then(response => {

            if (!response.ok) {
                throw new Error('Failed to load die information.');
            }

            return response.json();
        })
        .then(data => {

            console.log('Repeat info:', data);

            $('#repeat_back_date').val(data.back_date);

        })
        .catch(error => {

            console.error('Repeat info error:', error);

            $('#repeat_back_date').val('');

        });
};
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

 window.editDie = function (button) {

    const id = button.dataset.id;
    const dieCode = button.dataset.dieCode;
    const productId = button.dataset.productId;
    const rate = button.dataset.rate;
    const type = button.dataset.type;
    const repeatDate = button.dataset.repeatDate;
    const description = button.dataset.description;
    const repairCount = button.dataset.repairCount;

    $('#dieForm').attr(
        'action',
        "<?php echo e(url('dies')); ?>/" + id
    );

    $('#dieFormMethod').val('PUT');

    $('#dieModalTitle').text('Edit Die');
    $('#dieSubmitText').text('Update Die');

    // Die Code
    $('#dieCode').val(dieCode);

    // Product
    $('#dieProduct')
        .val(productId)
        .trigger('change');

    // Rate
    $('#dieRate').val(rate);

    // Type
    $('#dieType').val(type);

    // Repeat Date
    $('#dieRepeatDate').val(repeatDate);

    // Description
    $('#dieDescription').val(description);

    // Repair Count
    $('#dieRepairCount').val(repairCount || 0);

    handleDieType();

    $('#dieModal').addClass('active');

    $('body').css('overflow', 'hidden');
};




    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

window.viewDie = function (id) {

    // ------------------------------------------------------------
    // Validate ID
    // ------------------------------------------------------------
    if (!id) {
        console.error('VIEW DIE ERROR: Missing die ID');
        alert('Unable to load die details. Die ID is missing.');
        return;
    }

    // ------------------------------------------------------------
    // Build URL
    // ------------------------------------------------------------
    let url = "<?php echo e(route('dies.view.data', ':id')); ?>";
    url = url.replace(':id', encodeURIComponent(id));

    console.log('View Die URL:', url);

    // ------------------------------------------------------------
    // Show loading state if available
    // ------------------------------------------------------------
    $('#dieDetailModal').addClass('loading');

    // ------------------------------------------------------------
    // Fetch Die Details
    // ------------------------------------------------------------
    fetch(url, {
        method: 'GET',

        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },

        credentials: 'same-origin'
    })

    .then(async response => {

        console.log('Response status:', response.status);

        const text = await response.text();

        console.log('Response:', text);

        if (!response.ok) {

            let errorMessage = 'Unable to load die details.';

            try {
                const errorData = JSON.parse(text);

                errorMessage =
                    errorData.message ||
                    errorData.error ||
                    errorMessage;

            } catch (e) {
                // Response was not JSON
            }

            throw new Error(
                'HTTP ' + response.status + ': ' + errorMessage
            );
        }

        if (!text || !text.trim()) {
            throw new Error('Server returned an empty response.');
        }

        try {

            return JSON.parse(text);

        } catch (e) {

            console.error('Invalid JSON response:', text);

            throw new Error(
                'Server did not return valid JSON.'
            );
        }
    })

    .then(data => {

        console.log('Die details:', data);

        // --------------------------------------------------------
        // Normalize response
        // --------------------------------------------------------
        if (!data || typeof data !== 'object') {
            throw new Error('Invalid die details received from server.');
        }

        // Sometimes Laravel may return the data inside "data"
        if (
            data.data &&
            typeof data.data === 'object' &&
            !Array.isArray(data.data)
        ) {
            data = data.data;
        }

        console.log('Normalized die details:', data);


        // ========================================================
        // BASIC INFORMATION
        // ========================================================

        // Item Name
        $('#detailItemName').text(
            data.prod_name ??
            data.prod_name ??
            '—'
        );


        // Size
        const length =
            data.length ??
            data.die_length ??
            '—';

        const width =
            data.width ??
            data.die_width ??
            '—';

        $('#detailSize').text(
            length + ' × ' + width
        );


        // Rate
        const rate =
            data.rate ??
            data.die_rate ??
            '';

        $('#detailRate').text(
            rate !== '' && rate !== null && rate !== undefined
                ? rate
                : '—'
        );


        // UPS
        $('#detailUps').text(
            data.ups ??
            data.UPS ??
            '—'
        );


        // ========================================================
        // TYPE
        // ========================================================

        let type = String(
            data.type ??
            data.die_type ??
            'new'
        ).toLowerCase();

        // Remove all existing type classes first
        $('#detailType')
            .removeClass(
                'die-detail-type-new ' +
                'die-detail-type-repair ' +
                'die-detail-type-repeat'
            );


        // Default type
        let typeText = 'New';

        if (type === 'repeat') {

            typeText = 'Repeat';

            $('#detailType')
                .addClass('die-detail-type-repeat');

        } else if (type === 'repair') {

            typeText = 'Repair';

            $('#detailType')
                .addClass('die-detail-type-repair');

        } else {

            typeText = 'New';

            $('#detailType')
                .addClass('die-detail-type-new');
        }


        $('#detailType').text(typeText);


        // ========================================================
        // REPEAT DATE
        // ========================================================

        $('#detailRepeatDate').text(
            data.repeat_date ??
            data.repeatDate ??
            '—'
        );


        // ========================================================
        // REPAIR COUNT
        // ========================================================

        const repairCount =
            data.repair_count ??
            data.repairCount ??
            (
                Array.isArray(data.repairs)
                    ? data.repairs.length
                    : 0
            );

        $('#detailRepairCount').text(
            repairCount ?? 0
        );


        // ========================================================
        // DESCRIPTION
        // ========================================================

        const description =
            data.description ??
            data.die_description ??
            '';

        if (
            description !== null &&
            description !== undefined &&
            String(description).trim() !== ''
        ) {

            $('#detailDescription')
                .text(description);

            $('#detailDescriptionSection')
                .show();

        } else {

            $('#detailDescription')
                .text('');

            $('#detailDescriptionSection')
                .hide();
        }


        // ========================================================
        // REPAIR HISTORY
        // ========================================================

        let historyHtml = '';

        const repairs = Array.isArray(data.repairs)
            ? data.repairs
            : [];


        if (repairs.length > 0) {

            repairs.forEach(function (repair) {

                const repairDate =
                    repair.repair_date ??
                    repair.date ??
                    '—';

                const repairDescription =
                    repair.description ??
                    repair.reason ??
                    'Repair recorded';


                historyHtml += `

                    <div class="die-repair-history-item">

                        <div class="die-repair-history-date">

                            <i class="fas fa-calendar-days"></i>

                            <strong>
                                Repair Date:
                            </strong>

                            ${escapeHtml(repairDate)}

                        </div>


                        <div class="die-repair-history-description">

                            <i class="fas fa-wrench"></i>

                            ${escapeHtml(repairDescription)}

                        </div>

                    </div>

                `;
            });

        } else {

            historyHtml = `

                <div class="die-no-repair-history">

                    <i class="fas fa-screwdriver-wrench"></i>

                    No repair history available.

                </div>

            `;
        }


        $('#dieRepairHistory')
            .html(historyHtml);


        // ========================================================
        // REPEAT HISTORY
        // ========================================================

        let repeatHistoryHtml = '';

        const repeats = Array.isArray(data.repeats)
            ? data.repeats
            : [];


        console.log('Repeat history:', repeats);


        if (repeats.length > 0) {

            repeats.forEach(function (repeat) {

                // ------------------------------------------------
                // IMPORTANT:
                // Back Date must come from backend.
                // Do NOT replace it with repeat_date.
                // ------------------------------------------------

                const backDate =
                    repeat.back_date ??
                    repeat.backDate ??
                    '—';


                const repeatDate =
                    repeat.repeat_date ??
                    repeat.repeatDate ??
                    '—';


                const repeatDescription =
                    repeat.description ??
                    repeat.reason ??
                    'Repeat recorded';


                repeatHistoryHtml += `

                    <div class="die-repair-history-item">

                        <!-- BACK DATE -->
                        <div class="die-repair-history-date">

                            <i class="fas fa-calendar-days"></i>

                            <strong>
                                Back Date:
                            </strong>

                            ${escapeHtml(backDate)}

                        </div>


                        <!-- REPEAT DATE -->
                        <div class="die-repair-history-date">

                            <i class="fas fa-rotate-right"></i>

                            <strong>
                                Repeat Date:
                            </strong>

                            ${escapeHtml(repeatDate)}

                        </div>


                        <!-- DESCRIPTION -->
                        <div class="die-repair-history-description">

                            <i class="fas fa-align-left"></i>

                            ${escapeHtml(repeatDescription)}

                        </div>

                    </div>

                `;
            });

        } else {

            repeatHistoryHtml = `

                <div class="die-no-repair-history">

                    <i class="fas fa-rotate-right"></i>

                    No repeat history available.

                </div>

            `;
        }


        $('#dieRepeatHistory')
            .html(repeatHistoryHtml);


        // ========================================================
        // OPEN MODAL
        // ========================================================

        $('#dieDetailModal')
            .removeClass('loading')
            .addClass('active');

        $('body')
            .css('overflow', 'hidden');


        // --------------------------------------------------------
        // Debug
        // --------------------------------------------------------

        console.log('Die modal opened successfully.');
        console.log('Die ID:', id);
        console.log('Type:', type);
        console.log('Repair history count:', repairs.length);
        console.log('Repeat history count:', repeats.length);

    })

    .catch(error => {

        console.error(
            'VIEW DIE ERROR:',
            error
        );

        $('#dieDetailModal')
            .removeClass('loading');

        alert(
            'Unable to load die details.\n\n' +
            error.message
        );
    });
};



// ================================================================
// HTML ESCAPE HELPER
// Prevents descriptions containing HTML from breaking the modal
// ================================================================

function escapeHtml(value) {

    if (
        value === null ||
        value === undefined
    ) {
        return '—';
    }

    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
function repairDie(id) {

    fetch("<?php echo e(url('/probox/dies')); ?>/" + id + "/repair-data")
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
window.closeRepeatDieModal = function () {

    const modal = document.getElementById('repeatDieModal');

    if (modal) {
        modal.classList.remove('active');
    }

    document.body.style.overflow = '';
};
window.closeRepairDieModal = function () {

    $('#repairDieModal')
        .removeClass('active');

    $('body').css('overflow', '');

};
window.closeDieDetailModal = function() {

    $('#dieDetailModal')
        .removeClass('active');

    $('body').css('overflow', '');

};
$('#dieDetailModal').on('click', function(event) {

    if (event.target === this) {

        closeDieDetailModal();

    }

});


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
function renderRepairHistory(repairs)
{
    /*
    |--------------------------------------------------------------------------
    | UPDATE COUNT
    |--------------------------------------------------------------------------
    */

    $('#repairHistoryCount')
        .text(repairs.length);


    /*
    |--------------------------------------------------------------------------
    | NO HISTORY
    |--------------------------------------------------------------------------
    */

    if (!repairs.length) {

        $('#repairHistoryList').html(`

            <div class="repair-history-empty">

                <i class="fas fa-screwdriver-wrench"></i>

                <div style="margin-top:7px;">
                    No previous repairs recorded.
                </div>

            </div>

        `);

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD HISTORY
    |--------------------------------------------------------------------------
    */

    let html = '';


    repairs.forEach(function (repair) {

        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        let date = repair.repair_date || '';


        if (date) {

            let parsedDate =
                new Date(date);

            if (!isNaN(parsedDate)) {

                date =
                    parsedDate.toLocaleDateString(
                        'en-US',
                        {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric'
                        }
                    );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | REPAIR TYPES
        |--------------------------------------------------------------------------
        */

        let types =
            repair.repair_types || [];


        /*
        |--------------------------------------------------------------------------
        | Handle JSON string
        |--------------------------------------------------------------------------
        */

        if (typeof types === 'string') {

            try {

                types = JSON.parse(types);

            } catch (e) {

                types = [types];

            }

        }


        if (!Array.isArray(types)) {

            types = [];

        }


        let typesHtml = '';


        types.forEach(function (type) {

            typesHtml += `

                <span class="repair-history-type">

                    ${escapeRepairHtml(type)}

                </span>

            `;

        });


        /*
        |--------------------------------------------------------------------------
        | If no type
        |--------------------------------------------------------------------------
        */

        if (!typesHtml) {

            typesHtml = `

                <span class="repair-history-type">

                    General Repair

                </span>

            `;

        }


        /*
        |--------------------------------------------------------------------------
        | DESCRIPTION
        |--------------------------------------------------------------------------
        */

        let description =
            repair.description || '';


        let descriptionHtml =
            description
                ? escapeRepairHtml(description)
                : 'No description provided.';


        let descriptionClass =
            description
                ? 'repair-history-description'
                : 'repair-history-description empty';


        /*
        |--------------------------------------------------------------------------
        | CREATE HTML
        |--------------------------------------------------------------------------
        */

        html += `

            <div class="repair-history-item">

                <div class="repair-history-date">

                    <i class="fas fa-calendar-days"></i>

                    ${escapeRepairHtml(date)}

                </div>


                <div class="repair-history-types">

                    ${typesHtml}

                </div>


                <div class="${descriptionClass}">

                    ${descriptionHtml}

                </div>

            </div>

        `;

    });


    /*
    |--------------------------------------------------------------------------
    | INSERT
    |--------------------------------------------------------------------------
    */

    $('#repairHistoryList')
        .html(html);
}
function escapeRepairHtml(value)
{
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
window.repairDie = function (button) {

    /*
    |--------------------------------------------------------------------------
    | GET DATA FROM BUTTON
    |--------------------------------------------------------------------------
    */

    let id = $(button).data('id');

    let itemName = $(button).data('item_name');

    let length = $(button).data('length');

    let width = $(button).data('width');

    let repairCount = $(button).data('repair-count');


    console.log('Repair Die ID:', id);
    // console.log('Item Name:', itemName);
    console.log('Length:', length);
    console.log('Width:', width);
    console.log('Repair Count:', repairCount);


    /*
    |--------------------------------------------------------------------------
    | VALIDATE ID
    |--------------------------------------------------------------------------
    */

    if (!id) {

        alert('Invalid die ID.');

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | SET DIE ID
    |--------------------------------------------------------------------------
    */

    $('#repairDieId').val(id);


    /*
    |--------------------------------------------------------------------------
    | SET ITEM NAME
    |--------------------------------------------------------------------------
    */

    $('#repairItemNameText').text(
        itemName || 'Unknown Item'
    );


    /*
    |--------------------------------------------------------------------------
    | SET CURRENT DATE
    |--------------------------------------------------------------------------
    */

    let today =
        new Date().toISOString().split('T')[0];

    $('#repairDate').val(today);


    /*
    |--------------------------------------------------------------------------
    | RESET FORM
    |--------------------------------------------------------------------------
    */

    $('#repairDieForm input[name="repair_types[]"]')
        .prop('checked', false);

    $('#repairDescription').val('');


    /*
    |--------------------------------------------------------------------------
    | RESET HISTORY
    |--------------------------------------------------------------------------
    */

    $('#repairHistoryCount').text('0');

    $('#repairHistoryList').html(`
        <div class="repair-history-loading">

            <i class="fas fa-spinner fa-spin"></i>

            Loading repair history...

        </div>
    `);


    /*
    |--------------------------------------------------------------------------
    | OPEN MODAL
    |--------------------------------------------------------------------------
    */

    $('#repairDieModal').addClass('active');

    $('body').css('overflow', 'hidden');


    /*
    |--------------------------------------------------------------------------
    | LOAD REPAIR HISTORY
    |--------------------------------------------------------------------------
    */

    fetch(
        "<?php echo e(url('/probox/dies')); ?>/" + id + "/repair-data"
    )
    .then(response => {

        if (!response.ok) {

            throw new Error(
                'Failed to load repair history.'
            );

        }

        return response.json();

    })
    .then(data => {

        console.log(
            'Repair Data:',
            data
        );


        /*
        |--------------------------------------------------------------------------
        | UPDATE ITEM NAME
        |--------------------------------------------------------------------------
        */

        $('#repairItemNameText').text(
            data.item_name ||
            itemName ||
            'Unknown Item'
        );


        /*
        |--------------------------------------------------------------------------
        | UPDATE LENGTH / WIDTH
        |--------------------------------------------------------------------------
        */

        if (data.length !== undefined) {

            $('#repairLength').val(
                data.length
            );

        }

        if (data.width !== undefined) {

            $('#repairWidth').val(
                data.width
            );

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE CURRENT REPAIR COUNT
        |--------------------------------------------------------------------------
        */

        $('#repairCurrentCount').val(
            data.repair_count ?? repairCount ?? 0
        );


        /*
        |--------------------------------------------------------------------------
        | RENDER HISTORY
        |--------------------------------------------------------------------------
        */

        renderRepairHistory(
            data.repairs || []
        );

    })
    .catch(error => {

        console.error(
            'Repair history error:',
            error
        );


        $('#repairHistoryList').html(`

            <div class="repair-history-empty">

                <i class="fas fa-circle-exclamation"></i>

                Unable to load repair history.

            </div>

        `);

    });

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

        closeRepairDieModal();

        closeDieDetailModal();

    }

});

});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/dies/index.blade.php ENDPATH**/ ?>