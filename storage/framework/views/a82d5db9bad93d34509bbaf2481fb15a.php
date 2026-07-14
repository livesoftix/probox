<?php $__env->startSection('content'); ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&family=Noto+Nastaliq+Urdu:wght@500;700&display=swap');

:root{
    --primary:#1A237E;
    --accent:#4A90D9;
    --paper:#F5F7FA;
    --board:#E8EEF9;
    --board-line:#C9D9F1;
    --ink:#1C2333;
    --ink-soft:#5B6472;
    --ink-faint:#9AA3B2;
    --line:#E1E5EA;
    --card:#FFFFFF;

    --cyan:#00AEEF;
    --magenta:#EC008C;
    --yellow:#FFE000;
    --key:#151210;

    --ok:#2E7D5B;
    --ok-bg:#E1F1E9;
    --no:#C0392B;
    --no-bg:#FBE7E4;

    --shadow-sm:0 1px 2px rgba(26,35,126,.05),
                0 2px 8px -4px rgba(26,35,126,.12);

    --shadow-md:0 4px 14px -6px rgba(26,35,126,.16),
                0 1px 2px rgba(26,35,126,.06);

    --radius:12px;
}

*{
    box-sizing:border-box;
}

body{
    background:var(--paper);
    color:var(--ink);
    font-family:'Inter',sans-serif;
}

.job-print-wrapper{
    padding:32px 16px 80px;
}

.sheet{
    width:210mm;
    max-width:100%;
    margin:0 auto;
    background:var(--card);
    border:1px solid var(--line);
    border-radius:16px;
    overflow:hidden;
    box-shadow:var(--shadow-md);
}

/* =========================
   TOP BAR
========================= */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:28px 40px;
    gap:20px;
}

.brand{
    display:flex;
    align-items:center;
    gap:14px;
}

.brand-mark{
    display:flex;
    align-items:center;
    justify-content:center;
    width:44px;
    height:44px;
    border-radius:12px;
    background:var(--primary);
    color:#fff;
    font-weight:800;
    font-size:15px;
}

.brand-name{
    font-weight:800;
    font-size:22px;
    color:var(--ink);
}

.brand-sub{
    margin:2px 0 0;
    font-family:'JetBrains Mono',monospace;
    font-size:11.5px;
    font-weight:500;
    letter-spacing:.08em;
    text-transform:uppercase;
    color:var(--accent);
}

.meta-row{
    display:flex;
    align-items:stretch;
}

.meta-item{
    padding:0 20px;
    border-left:1px solid var(--line);
    text-align:right;
}

.meta-item:first-child{
    border-left:none;
}

.meta-item .lbl{
    font-size:10.5px;
    font-weight:600;
    letter-spacing:.1em;
    text-transform:uppercase;
    color:var(--ink-faint);
    margin-bottom:4px;
}

.meta-item .val{
    font-size:14.5px;
    font-weight:700;
    color:var(--ink);
}

.meta-item .val.mono{
    font-family:'JetBrains Mono',monospace;
    color:var(--primary);
}

/* =========================
   COLOR BAR
========================= */

.regbar{
    display:flex;
    height:4px;
}

.regbar span{
    flex:1;
}

.regbar span:nth-child(1){
    background:var(--cyan);
}

.regbar span:nth-child(2){
    background:var(--magenta);
}

.regbar span:nth-child(3){
    background:var(--yellow);
}

.regbar span:nth-child(4){
    background:var(--key);
}

.regbar span:nth-child(5){
    background:var(--primary);
    flex:0 0 30%;
}

/* =========================
   SECTION
========================= */

.section{
    padding:30px 40px;
}

.section + .section{
    border-top:1px solid var(--line);
}

.section-title{
    font-size:12.5px;
    font-weight:700;
    letter-spacing:.06em;
    text-transform:uppercase;
    color:var(--ink);
    margin:0 0 18px;
    display:flex;
    align-items:center;
    gap:8px;
}

.section-title svg{
    width:16px;
    height:16px;
    color:var(--accent);
    flex-shrink:0;
}

.section-title::after{
    content:"";
    flex:1;
    height:1px;
    background:var(--line);
}

/* =========================
   JOB DETAILS
========================= */

.meta-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px 24px;
}

.field .lbl{
    font-size:11px;
    color:var(--ink-soft);
    text-transform:uppercase;
    letter-spacing:.06em;
    margin-bottom:4px;
}

.field .val{
    font-family:'JetBrains Mono',monospace;
    font-size:15px;
    font-weight:500;
}

.field .val.empty{
    color:var(--ink-faint);
    font-weight:400;
}

.field--full{
    grid-column:1 / -1;
    padding-bottom:14px;
    margin-bottom:4px;
    border-bottom:1px dashed var(--line);
}

.field--full .val.product{
    font-family:'Inter',sans-serif;
    font-weight:700;
    font-size:19px;
}

.tag-pill{
    display:inline-block;
    padding:3px 11px;
    border-radius:999px;
    background:var(--board);
    border:1px solid var(--board-line);
    color:var(--primary);
    font-family:'Inter',sans-serif;
    font-size:13px;
    font-weight:600;
}

/* =========================
   BOXBOARD
========================= */

table.spec{
    width:100%;
    border-collapse:collapse;
    font-family:'JetBrains Mono',monospace;
    font-size:13px;
}

table.spec th{
    text-align:left;
    font-family:'Inter',sans-serif;
    font-weight:600;
    font-size:11px;
    letter-spacing:.05em;
    text-transform:uppercase;
    color:var(--ink-soft);
    padding:0 10px 10px 0;
    border-bottom:1px solid var(--line);
}

table.spec td{
    padding:12px 10px 12px 0;
    border-bottom:1px solid var(--line);
}

table.spec tr:last-child td{
    border-bottom:none;
}

.remaining-zero{
    color:var(--no);
    font-weight:700;
}

/* =========================
   PROCESS CHIPS
========================= */

.chip-grid{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
}

.chip{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:6px 12px;
    border-radius:999px;
    font-size:12.5px;
    font-weight:500;
    border:1px solid transparent;
}

.chip::before{
    content:"";
    width:6px;
    height:6px;
    border-radius:50%;
}

.chip--on{
    background:var(--ok-bg);
    color:var(--ok);
}

.chip--on::before{
    background:var(--ok);
}

.chip--off{
    background:transparent;
    color:var(--ink-faint);
    border-color:var(--line);
}

.chip--off::before{
    background:var(--ink-faint);
}

/* =========================
   FINISH CARDS
========================= */

.finish-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
    margin-top:18px;
}

.finish-card{
    border:1px solid var(--line);
    border-radius:var(--radius);
    padding:14px 16px;
    box-shadow:var(--shadow-sm);
}

.finish-card .fname{
    font-weight:600;
    font-size:13.5px;
    margin-bottom:8px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.finish-card dl{
    margin:0;
    font-size:12px;
    color:var(--ink-soft);
    display:grid;
    grid-template-columns:auto 1fr;
    gap:4px 10px;
}

.finish-card dd{
    margin:0;
    font-family:'JetBrains Mono',monospace;
    color:var(--ink);
}

.finish-card dd.empty{
    color:var(--ink-faint);
}

/* =========================
   NOTES
========================= */

.note-card{
    border:1px solid var(--line);
    border-left:3px solid var(--accent);
    border-radius:var(--radius);
    padding:16px 18px;
    font-size:14px;
    line-height:1.6;
    box-shadow:var(--shadow-sm);
}

.note-card .tag{
    font-family:'JetBrains Mono',monospace;
    font-size:10.5px;
    letter-spacing:.1em;
    text-transform:uppercase;
    color:var(--primary);
    display:block;
    margin-bottom:6px;
}

/* =========================
   FLOOR TRACKING
========================= */

.stages{
    display:flex;
    flex-direction:column;
    gap:14px;
}

.stage{
    border:1px solid var(--line);
    border-radius:var(--radius);
    overflow:hidden;
    box-shadow:var(--shadow-sm);
}

.stage-head{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 18px;
    background:var(--board);
    border-bottom:1px solid var(--board-line);
}

.stage-head .badge{
    display:flex;
    align-items:center;
    justify-content:center;
    width:24px;
    height:24px;
    border-radius:50%;
    background:var(--primary);
    color:#fff;
    font-family:'JetBrains Mono',monospace;
    font-size:11px;
    font-weight:600;
}

.stage-head .titles{
    flex:1;
    display:flex;
    justify-content:space-between;
    align-items:baseline;
    gap:12px;
}

.stage-head .en{
    font-family:'JetBrains Mono',monospace;
    font-size:10.5px;
    font-weight:500;
    letter-spacing:.08em;
    text-transform:uppercase;
    color:var(--ink-soft);
}

.stage-head .ur{
    font-family:'Noto Nastaliq Urdu',serif;
    font-size:19px;
    font-weight:700;
    color:var(--primary);
    direction:rtl;
}

.stage-body{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(140px,1fr));
    gap:1px;
    background:var(--line);
}

.stage-field{
    background:#fff;
    padding:10px 14px 12px;
}

.stage-field label{
    display:block;
    font-family:'Noto Nastaliq Urdu',serif;
    font-size:14px;
    direction:rtl;
    text-align:right;
    color:var(--ink-soft);
    margin-bottom:6px;
}

.stage-line{
    width:100%;
    height:26px;
    border-bottom:1.5px solid var(--board-line);
}

.footer{
    padding:22px 40px 30px;
    display:flex;
    align-items:center;
    justify-content:flex-start;
    border-top:1px solid var(--line);
}

.footer .stamp{
    font-family:'JetBrains Mono',monospace;
    font-size:11px;
    color:var(--ink-faint);
}

.job-actions{
    width:210mm;
    max-width:100%;
    margin:18px auto 0;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:10px;
    position:relative;
    z-index:99999;
}

.job-back-btn,
.job-print-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:10px 20px;
    border-radius:8px;
    font-size:13px;
    font-weight:600;
    text-decoration:none !important;
    cursor:pointer;
    position:relative;
    z-index:99999;
    pointer-events:auto !important;
}

.job-back-btn{
    background:#fff;
    color:var(--ink);
    border:1px solid var(--line);
}

.job-print-btn{
    background:var(--primary);
    color:#fff;
    border:1px solid var(--primary);
}

@media print{
    .no-print,
    .job-actions{
        display:none !important;
    }

    .footer{
        padding:10px 0 0;
        border-top:1px solid var(--line);
    }
}
/* =========================
   MOBILE
========================= */

@media(max-width:640px){

    .topbar{
        flex-direction:column;
        align-items:flex-start;
        padding:22px 20px;
    }

    .meta-row{
        width:100%;
        justify-content:space-between;
    }

    .meta-item{
        text-align:left;
        padding:0 10px;
    }

    .meta-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .finish-grid{
        grid-template-columns:1fr;
    }

    .section{
        padding:22px 20px;
    }
}

/* =========================
   PRINT
========================= */

@page{
    size:A4;
    margin:9mm 10mm;
}

@media print{

    body{
        background:#fff !important;
    }

    .navbar,
    .topbar-menu,
    .leftside-menu,
    .footer-wrapper,
    .no-print{
        display:none !important;
    }

    .content-page,
    .container-fluid{
        margin:0 !important;
        padding:0 !important;
    }

    .job-print-wrapper{
        padding:0 !important;
    }

    .sheet{
        width:100%;
        max-width:100%;
        box-shadow:none;
        border:none;
        border-radius:0;
    }

    .topbar{
        padding:0 0 10px;
    }

    .brand-mark{
        width:34px;
        height:34px;
        font-size:12px;
        border-radius:8px;
    }

    .brand-name{
        font-size:17px;
    }

    .brand-sub{
        font-size:9.5px;
    }

    .meta-item{
        padding:0 12px;
    }

    .meta-item .lbl{
        font-size:8.5px;
    }

    .meta-item .val{
        font-size:12px;
    }

    .regbar{
        height:3px;
    }

    .section{
        padding:10px 0;
    }

    .section-title{
        margin:0 0 8px;
        font-size:10.5px;
    }

    .section-title svg{
        width:12px;
        height:12px;
    }

    .meta-grid{
        gap:10px 20px;
    }

    .field .lbl{
        font-size:8.5px;
        margin-bottom:2px;
    }

    .field .val{
        font-size:11.5px;
    }

    .field--full{
        padding-bottom:8px;
    }

    .field--full .val.product{
        font-size:14px;
    }

    table.spec{
        font-size:10.5px;
    }

    table.spec th{
        padding:0 8px 6px 0;
        font-size:9px;
    }

    table.spec td{
        padding:6px 8px 6px 0;
    }

    .chip-grid{
        gap:5px;
    }

    .chip{
        padding:3px 9px;
        font-size:10px;
    }

    .finish-grid{
        gap:10px;
        margin-top:10px;
    }

    .finish-card{
        padding:8px 10px;
        box-shadow:none;
        break-inside:avoid;
    }

    .note-card{
        padding:8px 10px;
        box-shadow:none;
        break-inside:avoid;
    }

    .stages{
        gap:8px;
    }

    .stage{
        box-shadow:none;
        break-inside:avoid;
    }

    .stage-head{
        padding:6px 10px;
    }

    .stage-head .badge{
        width:18px;
        height:18px;
        font-size:9px;
    }

    .stage-head .en{
        font-size:8.5px;
    }

    .stage-head .ur{
        font-size:14px;
    }

    .stage-field{
        padding:5px 8px 6px;
    }

    .stage-field label{
        font-size:11px;
        margin-bottom:3px;
    }

    .stage-line{
        height:18px;
    }

    .footer{
        padding:10px 0 0;
    }

    .footer .stamp{
        font-size:9px;
    }
    .action-buttons{
    display:flex;
    align-items:center;
    gap:10px;
    position:relative;
    z-index:9999;
}

.back-btn,
.print-btn{
    position:relative;
    z-index:9999;
    pointer-events:auto !important;
    cursor:pointer !important;
}
}
</style>


<div class="job-print-wrapper">

<div class="sheet">

    

    <div class="topbar">

        <div class="brand">

            <span class="brand-mark">PB</span>

            <div>
                <div class="brand-name">
                    Pro-Box Packages
                </div>

                <p class="brand-sub">
                    Job Sheet · Production Control
                </p>
            </div>

        </div>

        <div class="meta-row">

            <div class="meta-item">
                <div class="lbl">Prepared By</div>
                <div class="val">
                    <?php echo e($job->preparedby ?: '—'); ?>

                </div>
            </div>

            <div class="meta-item">
                <div class="lbl">Job No.</div>
                <div class="val mono">
                    TJS-<?php echo e($job->v_no); ?>

                </div>
            </div>

            <div class="meta-item">
                <div class="lbl">Date</div>
                <div class="val mono">
                    <?php echo e($job->date); ?>

                </div>
            </div>

        </div>

    </div>


    <div class="regbar">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>


    

    <div class="section">

        <p class="section-title">

            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                <rect x="14" y="14" width="7" height="7" rx="1.5"/>

            </svg>

            Job Details

        </p>


        <div class="meta-grid">

            <div class="field field--full">

                <div class="lbl">
                    Product Name
                </div>

                <div class="val product">
                    <?php echo e($job->product?->prod_name ?: '—'); ?>

                </div>

            </div>


            <div class="field">

                <div class="lbl">
                    Printing For
                </div>

                <div class="val">

                    <?php if($job->printing_for): ?>

                        <span class="tag-pill">
                            <?php echo e($job->printing_for); ?>

                        </span>

                    <?php else: ?>

                        <span class="empty">—</span>

                    <?php endif; ?>

                </div>

            </div>


            <div class="field">
                <div class="lbl">Ups</div>
                <div class="val">
                    <?php echo e($job->ups ?? 0); ?>

                </div>
            </div>


            <div class="field">
                <div class="lbl">Qty of Boxes</div>
                <div class="val">
                    <?php echo e($job->qty ?? 0); ?>

                </div>
            </div>


            <div class="field">
                <div class="lbl">Size</div>
                <div class="val">
                    <?php echo e($job->size ?: '—'); ?>

                </div>
            </div>


            <div class="field">
                <div class="lbl">P. Size</div>
                <div class="val">
                    <?php echo e($job->p_size ?: '—'); ?>

                </div>
            </div>


            <div class="field">

                <div class="lbl">
                    M Date
                </div>

                <div class="val <?php echo e(!$job->m_date ? 'empty' : ''); ?>">
                    <?php echo e($job->m_date ?: '— pending'); ?>

                </div>

            </div>


            <div class="field">

                <div class="lbl">
                    E Date
                </div>

                <div class="val <?php echo e(!$job->e_date ? 'empty' : ''); ?>">
                    <?php echo e($job->e_date ?: '— pending'); ?>

                </div>

            </div>


            <div class="field">

                <div class="lbl">
                    No. of Colors
                </div>

                <div class="val">
                    <?php echo e($job->color_no ?? 0); ?>

                </div>

            </div>

        </div>

    </div>


    

    <div class="section">

        <p class="section-title">

            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                <polyline points="2 17 12 22 22 17"/>
                <polyline points="2 12 12 17 22 12"/>

            </svg>

            Boxboard

        </p>


        <table class="spec">

            <thead>

                <tr>
                    <th>Item</th>
                    <th>Length</th>
                    <th>Width</th>
                    <th>T. Stock</th>
                    <th>Used Qty</th>
                    <th>Remaining</th>
                </tr>

            </thead>


            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $job->boxboards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $box): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <?php
                        $remaining = $box->remain_stock ?? 0;
                        $usedQty = $box->qty ?? 0;
                        $totalStock = $remaining + $usedQty;
                    ?>

                    <tr>

                        <td>
                            <?php echo e($box->item->item_code ?? '—'); ?>

                        </td>

                        <td>
                            <?php echo e($box->length); ?>

                        </td>

                        <td>
                            <?php echo e($box->width); ?>

                        </td>

                        <td>
                            <?php echo e($totalStock); ?>

                        </td>

                        <td>
                            <?php echo e($usedQty); ?>

                        </td>

                        <td class="<?php echo e($remaining <= 0 ? 'remaining-zero' : ''); ?>">
                            <?php echo e($remaining); ?>

                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>
                        <td colspan="6">
                            No Boxboard Found
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>


    

    <div class="section">

        <p class="section-title">

            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <line x1="4" y1="21" x2="4" y2="14"/>
                <line x1="4" y1="10" x2="4" y2="3"/>
                <line x1="12" y1="21" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12" y2="3"/>
                <line x1="20" y1="21" x2="20" y2="16"/>
                <line x1="20" y1="12" x2="20" y2="3"/>

            </svg>

            Process

        </p>


        <div class="chip-grid">

            <span class="chip <?php echo e($job->color ? 'chip--on' : 'chip--off'); ?>">
                Design Color
            </span>

            <span class="chip <?php echo e($job->window ? 'chip--on' : 'chip--off'); ?>">
                Window
            </span>

            <span class="chip <?php echo e($job->glass_win ? 'chip--on' : 'chip--off'); ?>">
                Glass Window
            </span>

            <span class="chip <?php echo e($job->lam_window ? 'chip--on' : 'chip--off'); ?>">
                Lamination Window
            </span>

            <span class="chip <?php echo e($job->uv ? 'chip--on' : 'chip--off'); ?>">
                UV
            </span>

            <span class="chip <?php echo e($job->simple ? 'chip--on' : 'chip--off'); ?>">
                Simple
            </span>

            <span class="chip <?php echo e($job->spot ? 'chip--on' : 'chip--off'); ?>">
                Spot UV
            </span>

            <span class="chip <?php echo e($job->varnish ? 'chip--on' : 'chip--off'); ?>">
                Varnish
            </span>

            <span class="chip <?php echo e($job->emboss ? 'chip--on' : 'chip--off'); ?>">
                Emboss
            </span>

            <span class="chip <?php echo e($job->tripof ? 'chip--on' : 'chip--off'); ?>">
                Trip Of
            </span>

            <span class="chip <?php echo e($job->breaking ? 'chip--on' : 'chip--off'); ?>">
                Breaking
            </span>

        </div>


        <div class="finish-grid">

            

            <div class="finish-card">

                <div class="fname">

                    <span>Lamination</span>

                    <span class="chip <?php echo e($job->lamination ? 'chip--on' : 'chip--off'); ?>">
                        <?php echo e($job->lamination ? 'Yes' : 'No'); ?>

                    </span>

                </div>


                <dl>

                    <dt>Size</dt>

                    <dd class="<?php echo e(!$job->lam_size ? 'empty' : ''); ?>">
                        <?php echo e($job->lam_size ?: '—'); ?>

                    </dd>


                    <dt>Item</dt>

                    <dd class="<?php echo e(!$job->lamItem ? 'empty' : ''); ?>">
                        <?php echo e($job->lamItem->item_code ?? '—'); ?>

                    </dd>

                </dl>

            </div>


            

            <div class="finish-card">

                <div class="fname">

                    <span>Corrugation</span>

                    <span class="chip <?php echo e($job->corrugation ? 'chip--on' : 'chip--off'); ?>">
                        <?php echo e($job->corrugation ? 'Yes' : 'No'); ?>

                    </span>

                </div>


                <dl>

                    <dt>Size</dt>

                    <dd class="<?php echo e(!$job->curr_size ? 'empty' : ''); ?>">
                        <?php echo e($job->curr_size ?: '—'); ?>

                    </dd>


                    <dt>Item</dt>

                    <dd class="<?php echo e(!$job->currItem ? 'empty' : ''); ?>">
                        <?php echo e($job->currItem->item_code ?? '—'); ?>

                    </dd>

                </dl>

            </div>

        </div>

    </div>


    

    <div class="section">

        <p class="section-title">

            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>

            </svg>

            Notes

        </p>


        <div class="note-card">

            <span class="tag">
                <?php echo e($job->printing_for ?: 'Job Notes'); ?>

            </span>

            <?php echo e($job->note ?: 'No notes added.'); ?>


        </div>

    </div>


    

    <div class="section">

        <p class="section-title">

            <svg viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>

            </svg>

            Floor Tracking

        </p>


        <div class="stages">


            

            <div class="stage">

                <div class="stage-head">

                    <span class="badge">01</span>

                    <span class="titles">

                        <span class="en">
                            Printing Section
                        </span>

                        <span class="ur">
                            پرنٹنگ سیکشن
                        </span>

                    </span>

                </div>


                <div class="stage-body">

                    <div class="stage-field">
                        <label>مشین نام</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>مشین میں کل تعداد</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>منظور شدہ</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>ردی</label>
                        <div class="stage-line"></div>
                    </div>

                </div>

            </div>


            

            <div class="stage">

                <div class="stage-head">

                    <span class="badge">02</span>

                    <span class="titles">

                        <span class="en">
                            UV Coating / Lamination Section
                        </span>

                        <span class="ur">
                            یووی کوٹنگ / لیمینیشن سیکشن
                        </span>

                    </span>

                </div>


                <div class="stage-body">

                    <div class="stage-field">
                        <label>مشین میں کل تعداد</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>منظور شدہ</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>ردی</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>ردی بوجہ لیمینیشن</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>ان کوٹڈ</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>خراب پرنٹنگ</label>
                        <div class="stage-line"></div>
                    </div>

                </div>

            </div>


            

            <div class="stage">

                <div class="stage-head">

                    <span class="badge">03</span>

                    <span class="titles">

                        <span class="en">
                            Double Pasting / Die Cutting Section
                        </span>

                        <span class="ur">
                            ڈبل پیسٹنگ / ڈائی کٹنگ سیکشن
                        </span>

                    </span>

                </div>


                <div class="stage-body">

                    <div class="stage-field">
                        <label>مشین میں کل تعداد</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>منظور شدہ</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>ردی</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>ردی بوجہ لیمینیشن</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>ان کوٹڈ</label>
                        <div class="stage-line"></div>
                    </div>

                    <div class="stage-field">
                        <label>خراب پرنٹنگ</label>
                        <div class="stage-line"></div>
                    </div>

                </div>

            </div>


        </div>

    </div>


    

<!-- <div class="footer">

    <span class="stamp">
        TJS-<?php echo e($job->v_no); ?>

        · Generated <?php echo e(now()->format('d M Y, H:i')); ?>

    </span>

</div> -->

</div> 



<div class="job-actions no-print">

    <a href="<?php echo e(route('tempjob.index')); ?>"
       class="job-back-btn">
        Back
    </a>

    <button type="button"
            class="job-print-btn"
            onclick="window.print();">
        Print Job Sheet
    </button>

</div>

</div> 

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/temp_job_sheet/print.blade.php ENDPATH**/ ?>