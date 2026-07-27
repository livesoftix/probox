

<?php $__env->startSection('content'); ?>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

body{
    background:#eef2f7;
    font-family:'Segoe UI',sans-serif;
}
.container-fluid.fs{
    padding-top:70px !important;
}
.slip-wrapper{

    max-width:900px;
    margin:40px auto;
    padding-left:20px;

}

.slip-card{

    background:#fff;
    border-radius:18px;
    padding:40px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);

}

.header{

    display:flex;
    justify-content:space-between;
    align-items:flex-start;

}

.title{

    color:#0d6efd;
    font-size:28px;
    font-weight:800;
    letter-spacing:.5px;

}

.sub{

    color:#777;
    font-size:16px;
    margin-top:8px;

}

.right{

    text-align:right;

}

.right h5{

    margin-bottom:10px;
    font-size:16;
    font-weight:500;

}

.right strong{

    font-size:16px;

}

.blue-line{

    height:4px;
    background:#0d6efd;
    margin:28px 0 40px;
    border-radius:30px;

}

.label{

    color:#666;
    font-size:16px;
    font-weight:700;
    text-transform:uppercase;
    margin-bottom:8px;

}

.product{

    font-size:18px;
    font-weight:700;
    color:#222;
    margin-bottom:35px;

}

.status{

    display:inline-block;
    padding:10px 28px;
    border-radius:50px;
    font-size:16px;
    font-weight:700;
    letter-spacing:.5px;

}

.active{

    background:#d1fae5;
    color:#047857;

}

.inactive{

    background:#ffe4e6;
    color:#991b1b;

}

.description-box{

    margin-top:18px;
    background:#f6f8fc;
    border-left:6px solid #0d6efd;
    border-radius:14px;
    padding:35px;
    min-height:260px;
    font-size:20px;
    line-height:40px;
    color:#444;

}

.signature-area{

    margin-top:60px;
    border-top:2px dashed #ddd;
    padding-top:45px;

}

.signature{

    text-align:center;

}

.line{

    width:180px;
    border-top:2px solid #555;
    margin:0 auto 12px;

}

.person{

    font-size:24px;
    font-weight:700;

}

.designation{

    color:#666;
    font-size:15px;

}

.top-buttons{

    margin-bottom:25px;

}

@media print{

body{

background:#fff;

}

.top-buttons{

display:none;

}

.slip-wrapper{

margin:0;
max-width:100%;

}

.slip-card{

box-shadow:none;
padding:20px;

}

@page{

size:A4;
margin:12mm;

}

}

</style>

<div class="container-fluid fs mt-4">

<div class="slip-wrapper mt-4">

<?php if(!request()->routeIs('product-freezing.print')): ?>

<div class="top-buttons text-end">

<a href="<?php echo e(route('product-freezing.index')); ?>"
class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back

</a>

<button
class="btn btn-warning"
data-bs-toggle="modal"
data-bs-target="#editModal<?php echo e($productFreezing->id); ?>">

<i class="bi bi-pencil-square"></i>


Edit

</button>

<a href="<?php echo e(route('product-freezing.print',$productFreezing->id)); ?>"
target="_blank"
class="btn btn-primary">

<i class="bi bi-printer"></i>

Print

</a>

</div>

<?php endif; ?>

<div class="slip-card">

<div class="header">

<div>

<div class="title">

PRODUCT FREEZING SLIP

</div>
<!-- 
<div class="sub">

System Generated • Confidential Document

</div> -->

</div>

<div class="right">

<h5>

Date:
<strong><?php echo e(date('d-m-Y',strtotime($productFreezing->date))); ?></strong>

</h5>

<h5>

Slip No:
<strong><?php echo e($productFreezing->slip_no); ?></strong>

</h5>

</div>

</div>

<div class="blue-line"></div>

<div class="label">

PRODUCT NAME

</div>

<div class="product">

<?php echo e($productFreezing->product->prod_name); ?>


</div>

<div class="label">

STATUS

</div>

<?php if(strtolower($productFreezing->product->status)=='active'): ?>

<div class="status active">

ACTIVE

</div>

<?php else: ?>

<div class="status inactive">

INACTIVE

</div>

<?php endif; ?>

<div class="label mt-5">

DESCRIPTION

</div>

<div class="description-box">
    <?php if(!empty($productFreezing->description)): ?>

<?php echo nl2br(e($productFreezing->description)); ?>


<?php else: ?>

<span style="color:#999;">
No description available.
</span>

<?php endif; ?>

</div>

<div class="signature-area">

<div class="row">

<div class="col-6">

<div class="signature">

<div class="line"></div>

<div class="person">

<?php echo e($productFreezing->prepared_by ?: '_____________'); ?>


</div>

<div class="designation">

PREPARED BY

</div>

</div>

</div>

<div class="col-6">

<div class="signature">

<div class="line"></div>

<div class="person">

<?php echo e($productFreezing->production_by ?: '_____________'); ?>


</div>

<div class="designation">

PRODUCTION BY

</div>

</div>

</div>

</div>

</div>


</div>

</div>

</div>

</div>
<?php echo $__env->make('product_freezing.modal_edit', [
    'productFreezing' => $productFreezing,
    'products' => $products
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/product_freezing/show.blade.php ENDPATH**/ ?>