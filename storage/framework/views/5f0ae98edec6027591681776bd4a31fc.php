<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Product Freezing Slip</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:Arial,Helvetica,sans-serif;
    background:#eef2f7;
    padding:35px;
    color:#2d3748;

}

@page{

    size:A4;
    margin:12mm;

}

.sheet{

    width:100%;
    max-width:900px;
    margin:auto;
    background:#fff;
    border-radius:18px;
    padding:35px 45px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);

}

.header{

    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:25px;

}

.left h1{

    font-size:28px;
    color:#1d6ef5;
    font-weight:800;
    letter-spacing:.5px;

}

.left p{

    color:#777;
    margin-top:10px;
    font-size:16px;

}

.right{

    text-align:right;
    line-height:32px;

}

.right span{

    color:#666;
    font-weight:600;

}

.right strong{

    font-size:16px;
    color:#2d3748;

}

.blue-line{

    width:100%;
    height:4px;

    background-color:#0d6efd !important;

    border-top:4px solid #0d6efd;

    margin:20px 0 30px;

    -webkit-print-color-adjust:exact;
    print-color-adjust:exact;

}

.section{

    margin-bottom:35px;

}

.label{

    color:#666;
    font-size:16px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.5px;
    margin-bottom:5px;

}

.product{

    font-size:18px;
    font-weight:700;
    color:#222;
    line-height:55px;

}

.status{

    display:inline-block;
    padding:5px 32px;
    border-radius:30px;
    font-size:16px;
    font-weight:700;
    letter-spacing:.5px;
}

.status-active{

    background:#daf7e6;
    color:#0f7a38;

}

.status-inactive{

    background:#ffe3e3;
    color:#b42318;

}

.description{

    background:#f7f9fc;
    border-left:6px solid #1d6ef5;
    border-radius:12px;
    padding:28px;
    min-height:220px;
    line-height:38px;
    font-size:20px;
    color:#444;

}

.signature-area{

    margin-top:70px;
    border-top:2px dashed #d8d8d8;
    padding-top:45px;

}

.signature-table{

    width:100%;
    border-collapse:collapse;

}

.signature-table td{

    width:50%;
    text-align:center;

}

.sign-line{

    width:220px;
    border-top:2px solid #555;
    margin:18px auto 10px;

}

.sign-title{

    font-weight:700;
    color:#666;
    text-transform:uppercase;

}

.sign-name{

    font-size:22px;
    font-weight:700;
    margin-top:12px;

}

.footer{
    position:absolute;
    bottom:20px;
    right:40px;
}

.generated-on{
    text-align:right;
    font-size:14px;
    color:#666;
}

.print-btn{

    position:fixed;
    right:30px;
    top:30px;
    background:#1d6ef5;
    color:#fff;
    border:none;
    border-radius:8px;
    padding:12px 22px;
    cursor:pointer;
    font-size:15px;
}

@media print{

body{

background:white;
padding:0;

}

.sheet{

box-shadow:none;
border-radius:0;
padding:0;

}

.print-btn{

display:none;

}
*{
    -webkit-print-color-adjust:exact !important;
    print-color-adjust:exact !important;
}

}

</style>

</head>

<body>

<button
class="print-btn"
onclick="window.print()">

🖨 Print

</button>

<div class="sheet">

<div class="header">

<div class="left">

<h1>

PRODUCT FREEZING SLIP

</h1>

<p>

System Generated • Confidential Document

</p>

</div>

<div class="right">

<div>

<span>Date:</span>

<strong>

<?php echo e(\Carbon\Carbon::parse($productFreezing->date)->format('d-m-Y')); ?>


</strong>

</div>

<div>

<span>Slip No:</span>

<strong>

<?php echo e($productFreezing->slip_no); ?>


</strong>

</div>

</div>

</div>

<div class="blue-line"></div>
<!-- ============================= -->
<!-- Product Information -->
<!-- ============================= -->

<div class="section">

    <div class="label">

        PRODUCT NAME

    </div>

    <div class="product">

        <?php echo e($productFreezing->product->prod_name); ?>


    </div>

</div>

<div class="section">

    <div class="label">

        STATUS

    </div>

    <?php if(strtolower($productFreezing->product->status) == 'active'): ?>

        <span class="status status-active">

            ACTIVE

        </span>

    <?php else: ?>

        <span class="status status-inactive">

            INACTIVE

        </span>

    <?php endif; ?>

</div>

<!-- ============================= -->
<!-- Description -->
<!-- ============================= -->

<div class="section">

    <div class="label">

        DESCRIPTION

    </div>

    <div class="description">

        <?php if(!empty($productFreezing->description)): ?>

            <?php echo nl2br(e($productFreezing->description)); ?>


        <?php else: ?>

            No description available.

        <?php endif; ?>

    </div>

</div>

<!-- ============================= -->
<!-- Signature Section -->
<!-- ============================= -->

<div class="signature-area">

<table class="signature-table">

<tr>

<td>

<div class="sign-line"></div>

<div class="sign-title">

PREPARED BY

</div>

<div class="sign-name">

<?php echo e($productFreezing->prepared_by ?: '_____________'); ?>


</div>

</td>

<td>

<div class="sign-line"></div>

<div class="sign-title">

PRODUCTION BY

</div>

<div class="sign-name">

<?php echo e($productFreezing->production_by ?: '_____________'); ?>


</div>

</td>

</tr>

</table>

</div>
<!-- ============================= -->
<!-- Footer -->
<!-- ============================= -->
<div class="footer">

    <div class="generated-on">

        <strong>Generated On</strong><br>

        <?php echo e(now()->format('d-m-Y h:i A')); ?>


    </div>

</div>


</div> <!-- sheet -->

<script>

window.onload=function(){

    window.print();

};

window.onafterprint=function(){

    window.close();

};

</script>

</body>

</html><?php /**PATH C:\laragon\www\probox\resources\views/product_freezing/print.blade.php ENDPATH**/ ?>