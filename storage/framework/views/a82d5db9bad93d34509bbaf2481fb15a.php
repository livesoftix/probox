<?php $__env->startSection('content'); ?>
<style>
.urdu-section{
    direction: rtl;
    font-family: "Jameel Noori Nastaleeq","Noto Nastaliq Urdu",serif;
    font-size: 20px;
    margin-top: 20px;
}

.urdu-title{
    font-weight: bold;
    font-size: 26px;
    text-align: center;
    margin: 15px 0;
}

.urdu-row{
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 8px 0;
}

.urdu-line{
    flex: 1;
    border-bottom: 1px solid #000;
    height: 25px;
}

.note-box{
    border:1px solid #000;
    height:180px;
    margin-top:10px;
    position:relative;
}

.note-box .line{
    border-bottom:1px solid #ccc;
    height:35px;
}

.note-label{
    font-weight:bold;
    margin-bottom:5px;
}

.a4-sheet{
    width:210mm;
    min-height:297mm;
    margin:auto;
    background:#fff;
    padding:10mm;
    box-sizing:border-box;
}

/* =========================
   TABLE BASE STYLE
========================= */
.table-bordered{
    width:100%;
    border-collapse:collapse;
}

/* ✅ HEADINGS FIX */
.table-bordered th{
    border:1px solid #000;
    padding:6px;
    background:#fff !important;

    color:#000 !important;
    font-weight:700 !important;
    text-align:left;
}

/* ✅ TABLE CELLS */
.table-bordered td{
    border:1px solid #000;
    padding:6px;
    background:#fff !important;
    color:#000 !important;
}

/* remove striping */
.table-bordered tr{
    background:#fff !important;
}

/* =========================
   PRINT FIX
========================= */
@media print{
    .no-print{
        display:none !important;
    }

    body{
        margin:0;
        background:#fff;
        color:#000;
    }

    .a4-sheet{
        border:none;
        box-shadow:none;
        background:#fff;
    }

    table, tr, td, th{
        background:#fff !important;
        color:#000 !important;
    }

    th{
        font-weight:700 !important;
        color:#000 !important;
    }
}
</style>

<div class="container-fluid">

    <div class="mb-3 mt-5 no-print">
        <button onclick="window.print()" class="btn btn-primary">
            Print Job Sheet
        </button>

        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="a4-sheet">

        <h3 class="text-center mb-3">JOB SHEET</h3>

        
       <table class="table-bordered">
    <tr>
        <th>Date</th>
        <td><?php echo e($job->date); ?></td>

        <th>Job No</th>
        <td>TJS-<?php echo e($job->v_no); ?></td>

       
    </tr>

   

    <tr>
         <th>Prepared By</th>
        <td><?php echo e($job->preparedby); ?></td>
        <th>Printing For</th>
        <td colspan="5"><?php echo e($job->printing_for); ?></td>

    </tr>
     <tr>
        <th>Job Name</th>
        <td colspan="5"><?php echo e($job->product?->prod_name); ?></td>
    </tr>

    <tr>
        <th>Size</th>
        <td><?php echo e($job->size); ?></td>

        <th>P.Size</th>
        <td colspan="3"><?php echo e($job->p_size); ?></td>
    </tr>

    <tr>
        <th>M Date</th>
        <td><?php echo e($job->m_date); ?></td>

        <th>E Date</th>
        <td colspan="3"><?php echo e($job->e_date); ?></td>
    </tr>
</table>

        <br>

        
        <h4>Boxboard</h4>

        <table class="table-bordered">
            <thead>
    <tr>
        <th>#</th>
        <th>Item</th>
        <th>Length</th>
        <th>Width</th>
        <th>T.Stock</th>
        <th>Used Qty</th>
        <th>Remaining</th>
    </tr>
</thead>

<tbody>
<?php $__empty_1 = true; $__currentLoopData = $job->boxboards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $box): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td><?php echo e($key + 1); ?></td>
        <td><?php echo e($box->item->item_code ?? ''); ?></td>
        <td><?php echo e($box->length); ?></td>
        <td><?php echo e($box->width); ?></td>

        
        <td><?php echo e($box->t_stock ?? 0); ?></td>

        <td><?php echo e($box->qty); ?></td>

        <td><?php echo e($box->t_stock-$box->qty ?? 0); ?></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td colspan="7" class="text-center">No Boxboard Found</td>
    </tr>
<?php endif; ?>
</tbody>
        </table>

        <br>

        
        <h4>Process</h4>

        <table class="table-bordered">
            <tr>
                <th>Lamination</th>
                <td><?php echo e($job->lamination); ?></td>

                <th>Embossing</th>
                <td><?php echo e($job->embossing); ?></td>
            </tr>

            <tr>
                <th>Varnish</th>
                <td><?php echo e($job->varnish); ?></td>

                <th>Colour</th>
                <td><?php echo e($job->colour); ?></td>
            </tr>

            <tr>
                <th>UV</th>
                <td><?php echo e($job->uv); ?></td>

                <th></th>
                <td></td>
            </tr>
        </table>

        <br>

        
        <h4>Note</h4>
        <table class="table-bordered">
            <tr>
                <td style="height:60px;">
                    <?php echo e($job->note); ?>

                </td>
            </tr>
        </table>
<hr style="margin:30px 0;">

<div class="urdu-section">

    <div class="urdu-title">
         جاب پرنٹنگ سیکشن
    </div>

    <div class="urdu-row">
        <span>مشین نام</span>
        <div class="urdu-line"></div>
    </div>

    <div class="urdu-row">
        <span>مشین مین</span>
        <div class="urdu-line"></div>
</div>
<div class="urdu-row">
    <span>کلر نام</span>
        <div class="urdu-line"></div>

        <span>تعداد</span>
        <div class="urdu-line"></div>

        <span>منظور شدہ</span>
        <div class="urdu-line"></div>

        <span>ردی</span>
        <div class="urdu-line"></div>

        
    </div>

  


    <div class="urdu-title">
        یووی کوٹنگ / لیمینیشن سیکشن
    </div>

    <div class="urdu-row">
         <span>مشین مین</span>
        <div class="urdu-line"></div>

        
    </div>
    <div class="urdu-row">
         <span>کل تعداد</span>
        <div class="urdu-line"></div>

        <span>منظور شدہ</span>
        <div class="urdu-line"></div>

        <span>ردی</span>
        <div class="urdu-line"></div>
</div>

    <div class="urdu-row">
        <span>ردی بوجہ لیمینیشن</span>
        <div class="urdu-line"></div>

        <span>ان کوٹڈ</span>
        <div class="urdu-line"></div>

        <span>خراب پرنٹنگ</span>
        <div class="urdu-line"></div>
    </div>


    <div class="urdu-title">
        ڈبل پیسٹنگ / ڈائی کٹنگ سیکشن
    </div>

     <div class="urdu-row">
         <span>مشین مین</span>
        <div class="urdu-line"></div>

        
    </div>
    <div class="urdu-row">
        <span>کل تعداد</span>
        <div class="urdu-line"></div>

        <span>منظور شدہ</span>
        <div class="urdu-line"></div>

        <span>ردی</span>
        <div class="urdu-line"></div>
</div>
    <div class="urdu-row">
         <span>ردی بوجہ لیمینیشن</span>
        <div class="urdu-line"></div>

        <span>ان کوٹڈ</span>
        <div class="urdu-line"></div>

        <span>خراب پرنٹنگ</span>
        <div class="urdu-line"></div>
    </div>

    <br>

    <div class="note-label">نوٹ</div>

    <div class="note-box">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>

</div>
        <br><br>

        
        <!-- <table class="table-bordered">
            <tr>
                <td style="text-align:center;">
                    Prepared By<br><br>______________
                </td>

                <td style="text-align:center;">
                    Manager<br><br>______________
                </td>

                <td style="text-align:center;">
                    Approved By<br><br>______________
                </td>
            </tr>
        </table> -->

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/temp_job_sheet/print.blade.php ENDPATH**/ ?>