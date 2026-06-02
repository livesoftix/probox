<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                        <li class="breadcrumb-item active">Stock Reports</li>
                    </ol>
                </div>
                <h3 class="page-title">Stock Reports</h3>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    <!-- Search Form -->
    <div class="row">
        <div class="card mt-2">
            <div class="card-body">
                <div class="tab-content">
                    <div class="col-12">
                        <form action="<?php echo e(route('report.stock')); ?>" method="GET" class="form-inline" id="search-form">
                            <div class="row">
                                <!-- Start Date -->
                                <div class="form-group col-xl-2" style="display:none;">
                                    <label for="start_date" class="sr-only">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="">
                                </div>
                                <!-- End Date -->
                                <div class="form-group col-xl-2">
                                    <label for="end_date" class="sr-only">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="">
                                </div>
                                <!-- Voucher No Dropdown -->
                                <div class="form-group col-xl-2">
                                    <label for="product_type" class="sr-only">Select Purchase</label>
                                    <select name="product_type" class="form-control select2" data-toggle="select2"
                                        id="product_type">
                                        <option value="">Select</option>
                                        <option value="Purchase Boxboard">Purchase Boxboard</option>
                                        <option value="Purchase Plate">Purchase Plate</option>
                                        <option value="Glue Purchase">Glue Purchase</option>
                                        <option value="Ink Purchase">Ink Purchase</option>
                                        <option value="Lamination Purchase">Lamination Purchase</option>
                                        <option value="Corrugation Purchase">Corrugation Purchase</option>
                                        <option value="Shipper Purchase">Shipper Purchase</option>
                                        <option value="Dye Purchase">Dye Purchase</option>
                                        <option value="disposable">Disposable Purchase</option>
                                        
                                    </select>
                                </div>

                               



                                <!-- Search and Add New Buttons -->
                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Combined Data Table -->
    <div class="row">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-secondary" style="width: 100px;" onclick="printTable()">Print
                    Table</button>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="col-12">
                                <?php if(empty($productType)): ?>
                                <?php
                                $groupedBoxboardData = [];
                                foreach ($trndtl as $data) {
                                $itemCode = $data->purchasedetails->items->item_code ?? 'N/A';
                                $width = $data->purchasedetails->width ?? 'N/A';
                                $length = $data->purchasedetails->lenght ?? 'N/A';
                                $grammage = $data->purchasedetails->grammage ?? 'N/A';
                                $qty = $data->purchasedetails->qty ?? 0;
                                $weight = $data->purchasedetails->total_wt ?? 0;

                                // Create a unique key combining item_code, width, length, and grammage
                                $key = $itemCode . '|' . $width . '|' . $length . '|' . $grammage;

                                if (!isset($groupedBoxboardData[$key])) {
                                $groupedBoxboardData[$key] = [
                                'item_code' => $itemCode,
                                'width' => $width,
                                'length' => $length,
                                'grammage' => $grammage,
                                'qty' => $qty,
                                'total_wt' => $weight
                                ];
                                } else {
                                $groupedBoxboardData[$key]['qty'] += $qty;
                                $groupedBoxboardData[$key]['total_wt'] += $weight;
                                }
                                }
                                ?>

                                <table id="combined-data-table-boxboard"
                                    class="table table-striped dt-responsive nowrap w-100">
                                    <hr>
                                    <h2 for="boxboard">Purchase Boxboard Details</h2><hr>
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Length</th>
                                            <th>Width</th>
                                            
                                            <th>Grammage</th>
                                            
                                            <th>Weights</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    <?php $__currentLoopData = $boxboardData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($data->item_code); ?></td>
        <td><?php echo e($data->length); ?></td>
        <td><?php echo e($data->width); ?></td>
        
        <td><?php echo e($data->grammage); ?></td>
        
        <td><?php echo e($data->total_wt); ?></td>
        <td><?php echo e($data->remain_qty); ?></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
                                </table>

                                


                                 <?php
    $groupedPlateData = [];
    foreach ($trndtl2 as $data) {
        $itemCode = $data->purchaseplates->items->item_code ?? 'N/A';
        $prodName = $data->purchaseplates->products->prod_name ?? 'N/A';
        $country = $data->purchaseplates->countries->country_name ?? 'N/A';
        $qty = $data->purchaseplates->qty ?? 0;
        
        // Create a unique key combining item_code and prod_name
        $key = $itemCode . '|' . $prodName;

        if (!isset($groupedPlateData[$key])) {
            $groupedPlateData[$key] = [
                'item_code' => $itemCode,
                'prod_name' => $prodName,
                'qty' => $qty,
                'country' => $country
            ];
        } else {
            $groupedPlateData[$key]['qty'] += $qty;
        }
    }
?>

<table id="combined-data-table-plate" class="table table-striped dt-responsive nowrap w-100">
    <hr><h2 for="plate">Purchase Plate Details</h2>
    <hr>
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Product Name</th>
            <th>Country</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $plateData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($data->item_code); ?></td>
            <td><?php echo e($data->product_name); ?></td>
            <td><?php echo e($data->country_name); ?></td>
            <td><?php echo e($data->remain_qty); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>


                                <?php
                                $groupedData = [];
                                foreach ($trndtl3 as $data) {
                                $itemCode = $data->gluepurchases->items->item_code ?? 'N/A';
                                $qty = $data->gluepurchases->qty ?? 0;

                                if (!isset($groupedData[$itemCode])) {
                                $groupedData[$itemCode] = $qty;
                                } else {
                                $groupedData[$itemCode] += $qty;
                                }
                                }
                                ?>

                                <table id="combined-data-table-glue"
                                    class="table table-striped dt-responsive nowrap w-100">
                                   <hr> <h2 for="glue">Glue Purchase Details</h2> <hr>
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php $__currentLoopData = $glueData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $glue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                              <td><?php echo e($glue->item); ?></td>
                                              <td><?php echo e($glue->remain_qty); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>

                                <?php
                                $groupedInkData = [];
                                foreach ($trndtl4 as $data) {
                                $itemCode = $data->inkpurchases->items->item_code ?? 'N/A';
                                $qty = $data->inkpurchases->qty ?? 0;

                                if (!isset($groupedInkData[$itemCode])) {
                                $groupedInkData[$itemCode] = $qty;
                                } else {
                                $groupedInkData[$itemCode] += $qty;
                                }
                                }
                                ?>

                                <table id="combined-data-table-ink"
                                    class="table table-striped dt-responsive nowrap w-100">
                                    <hr><h2 for="ink">Ink Purchase Details</h2><hr>
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $inkData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ink): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                              <td><?php echo e($ink->item); ?></td>
                                              <td><?php echo e($ink->remain_qty); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>


                                <?php
                                $groupedLaminationData = [];
                                foreach ($trndtl5 as $data) {
                                $itemCode = $data->leminationpurchases->item->item_code ?? 'N/A';
                                $size = $data->leminationpurchases->size ?? 'N/A';
                                $qty = $data->leminationpurchases->qty ?? 0;

                                // Create a unique key using item_code and size
                                $key = $itemCode . '|' . $size;

                                if (!isset($groupedLaminationData[$key])) {
                                $groupedLaminationData[$key] = [
                                'item_code' => $itemCode,
                                'size' => $size,
                                'qty' => $qty
                                ];
                                } else {
                                $groupedLaminationData[$key]['qty'] += $qty;
                                }
                                }
                                ?>

                                <table id="combined-data-table-lamination"
                                    class="table table-striped dt-responsive nowrap w-100">
                                    <hr><h2 for="lamination">Lamination Purchase Details</h2><hr>
                                    <thead>
                                        <tr>
                                            <th>Lamination Type</th>
                                            
                                            <th>Size</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $laminationData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($data->item_name ?? 'N/A'); ?></td>
             <td><?php echo e($data->size  ?? 'N/A'); ?></td>
            <td><?php echo e($data->remain_qty  ?? 'N/A'); ?></td>
           
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>


                                <?php
                                $groupedCorrugationData = [];
                                foreach ($trndtl6 as $data) {
                                $itemCode = $data->corrugationpurchases->item->item_code ?? 'N/A';
                                $size = $data->corrugationpurchases->size ?? 'N/A';
                                $qty = $data->corrugationpurchases->qty ?? 0;

                                // Create a unique key using item_code and size
                                $key = $itemCode . '|' . $size;

                                if (!isset($groupedCorrugationData[$key])) {
                                $groupedCorrugationData[$key] = [
                                'item_code' => $itemCode,
                                'size' => $size,
                                'qty' => $qty
                                ];
                                } else {
                                $groupedCorrugationData[$key]['qty'] += $qty;
                                }
                                }
                                ?>

                                <table id="combined-data-table-corrugation"
    class="table table-striped dt-responsive nowrap w-100">
    <hr><h2 for="corrugation">Corrugation Purchase Details</h2><hr>
    <thead>
        <tr>
            <th>Corrugation Type</th>
           
            <th>Size</th>
             <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $corrugationData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($data->item_name ?? 'N/A'); ?></td>
              <td><?php echo e($data->size  ?? 'N/A'); ?></td>
            <td><?php echo e($data->remain_qty  ?? 'N/A'); ?></td>
          
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>



                                <?php
                                $groupedShipperData = [];
                                foreach ($trndtl7 as $data) {
                                $itemCode = $data->shipperpurchases->items->item_code ?? 'N/A';
                                $qty = $data->shipperpurchases->qty ?? 0;

                                if (!isset($groupedShipperData[$itemCode])) {
                                $groupedShipperData[$itemCode] = $qty;
                                } else {
                                $groupedShipperData[$itemCode] += $qty;
                                }
                                }
                                ?>

                                <table id="combined-data-table-shipper"
       class="table table-striped dt-responsive nowrap w-100">
    <hr><h2 for="shipper">Shipper Purchase Details</h2><hr>
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $shipperData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemshipper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($itemshipper->item  ?? 'N/A'); ?></td>
                <td><?php echo e($itemshipper->remain_qty  ?? 'N/A'); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>


                                    <!-- Disposable Purchase Details -->
                                    <table id="combined-data-table-disposable"
                                           class="table table-striped dt-responsive nowrap w-100">
                                        <hr><h2 for="disposable">Disposable Purchase Details</h2><hr>
                                        <thead>
                                            <tr>
                                                <th>Item Code</th>
                                                <th>Qty</th>
                                                <th>Rate</th>
                                                <th>Weight Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $disposableData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disposable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($disposable->item_code ?? 'N/A'); ?></td>
                                                <td><?php echo e($disposable->qty ?? 0); ?></td>
                                                <td><?php echo e($disposable->rate ?? '-'); ?></td>
                                                <td><?php echo e($disposable->weight_type ?? '-'); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>

 <table id="combined-data-table-dye"
       class="table table-striped dt-responsive nowrap w-100">
    <hr><h2 for="dye">Dye Purchase Details</h2><hr>
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $dyeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dye): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($dye->item_name  ?? 'N/A'); ?></td>
                <td><?php echo e($dye->remain_qty  ?? 'N/A'); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>




                                <!-- Now sum the grand totals from both tables -->



                                <?php elseif($productType == 'BPN'): ?>
                                <?php
                                $groupedBoxboardData = [];
                                foreach ($trndtl as $data) {
                                $itemCode = $data->purchasedetails->items->item_code ?? 'N/A';
                                $width = $data->purchasedetails->width ?? 'N/A';
                                $length = $data->purchasedetails->lenght ?? 'N/A';
                                $grammage = $data->purchasedetails->grammage ?? 'N/A';
                                $qty = $data->purchasedetails->qty ?? 0;
                                $weight = $data->purchasedetails->total_wt ?? 0;

                                // Create a unique key combining item_code, width, length, and grammage
                                $key = $itemCode . '|' . $width . '|' . $length . '|' . $grammage;

                                if (!isset($groupedBoxboardData[$key])) {
                                $groupedBoxboardData[$key] = [
                                'item_code' => $itemCode,
                                'width' => $width,
                                'length' => $length,
                                'grammage' => $grammage,
                                'qty' => $qty,
                                'total_wt' => $weight
                                ];
                                } else {
                                $groupedBoxboardData[$key]['qty'] += $qty;
                                $groupedBoxboardData[$key]['total_wt'] += $weight;
                                }
                                }
                                ?>

                                <table id="combined-data-table-boxboard"
                                    class="table table-striped dt-responsive nowrap w-100">
                                    <h4 for="boxboard">Purchase Boxboard Details</h4>
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Length</th>
                                            <th>Width</th>
                                            
                                            <th>Grammage</th>
                                            
                                            <th>Weights</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    <?php $__currentLoopData = $boxboardData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($data->item_code); ?></td>
        <td><?php echo e($data->length); ?></td>
        <td><?php echo e($data->width); ?></td>
        
        <td><?php echo e($data->grammage); ?></td>
        
        <td><?php echo e($data->total_wt); ?></td>
        <td><?php echo e($data->remain_qty); ?></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
                                </table>

                            

                                <?php elseif($productType == 'PPN'): ?>
                               <?php
    $groupedPlateData = [];
    foreach ($trndtl2 as $data) {
        $itemCode = $data->purchaseplates->items->item_code ?? 'N/A';
        $prodName = $data->purchaseplates->products->prod_name ?? 'N/A';
        $country = $data->purchaseplates->countries->country_name ?? 'N/A';
        $qty = $data->purchaseplates->qty ?? 0;
        
        // Create a unique key combining item_code and prod_name
        $key = $itemCode . '|' . $prodName;

        if (!isset($groupedPlateData[$key])) {
            $groupedPlateData[$key] = [
                'item_code' => $itemCode,
                'prod_name' => $prodName,
                'qty' => $qty,
                'country' => $country
            ];
        } else {
            $groupedPlateData[$key]['qty'] += $qty;
        }
    }
?>

<table id="combined-data-table-plate" class="table table-striped dt-responsive nowrap w-100">
    <h4 for="plate">Purchase Plate Details</h4>
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Product Name</th>
            <th>Country</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
         <?php $__currentLoopData = $plateData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($data->item_code); ?></td>
            <td><?php echo e($data->product_name); ?></td>
            <td><?php echo e($data->country_name); ?></td>
            <td><?php echo e($data->remain_qty); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

                                <?php elseif($productType == 'GPN'): ?>
                               <?php
                                $groupedData = [];
                                foreach ($trndtl3 as $data) {
                                $itemCode = $data->gluepurchases->items->item_code ?? 'N/A';
                                $qty = $data->gluepurchases->qty ?? 0;

                                if (!isset($groupedData[$itemCode])) {
                                $groupedData[$itemCode] = $qty;
                                } else {
                                $groupedData[$itemCode] += $qty;
                                }
                                }
                                ?>

                                <table id="combined-data-table-glue"
                                    class="table table-striped dt-responsive nowrap w-100">
                                    <h4 for="glue">Glue Purchase Details</h4>
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $glueData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $glue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                              <td><?php echo e($glue->item); ?></td>
                                              <td><?php echo e($glue->remain_qty); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>

                                <?php elseif($productType == 'IPN'): ?>
                                <?php
                                $groupedInkData = [];
                                foreach ($trndtl4 as $data) {
                                $itemCode = $data->inkpurchases->items->item_code ?? 'N/A';
                                $qty = $data->inkpurchases->qty ?? 0;

                                if (!isset($groupedInkData[$itemCode])) {
                                $groupedInkData[$itemCode] = $qty;
                                } else {
                                $groupedInkData[$itemCode] += $qty;
                                }
                                }
                                ?>

                                <table id="combined-data-table-ink"
                                    class="table table-striped dt-responsive nowrap w-100">
                                    <h4 for="ink">Ink Purchase Details</h4>
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php $__currentLoopData = $inkData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ink): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                              <td><?php echo e($ink->item); ?></td>
                                              <td><?php echo e($ink->remain_qty); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>


                                <?php elseif($productType == 'LPN'): ?>
                                 <?php
                                $groupedLaminationData = [];
                                foreach ($trndtl5 as $data) {
                                $itemCode = $data->leminationpurchases->item->item_code ?? 'N/A';
                                $size = $data->leminationpurchases->size ?? 'N/A';
                                $qty = $data->leminationpurchases->qty ?? 0;

                                // Create a unique key using item_code and size
                                $key = $itemCode . '|' . $size;

                                if (!isset($groupedLaminationData[$key])) {
                                $groupedLaminationData[$key] = [
                                'item_code' => $itemCode,
                                'size' => $size,
                                'qty' => $qty
                                ];
                                } else {
                                $groupedLaminationData[$key]['qty'] += $qty;
                                }
                                }
                                ?>

                               <table id="combined-data-table-lamination"
                                    class="table table-striped dt-responsive nowrap w-100">
                                    <h4 for="lamination">Lamination Purchase Details</h4>
                                    <thead>
                                        <tr>
                                            <th>Lamination Type</th>
                                            <th>Size</th>
                                            <th>Qty</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $laminationData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($data->item_name); ?></td>
            <td><?php echo e($data->size); ?></td>
            <td><?php echo e($data->remain_qty); ?></td>
            
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>


                                <?php elseif($productType == 'CPN'): ?>
                                 <?php
                                $groupedCorrugationData = [];
                                foreach ($trndtl6 as $data) {
                                $itemCode = $data->corrugationpurchases->item->item_code ?? 'N/A';
                                $size = $data->corrugationpurchases->size ?? 'N/A';
                                $qty = $data->corrugationpurchases->qty ?? 0;

                                // Create a unique key using item_code and size
                                $key = $itemCode . '|' . $size;

                                if (!isset($groupedCorrugationData[$key])) {
                                $groupedCorrugationData[$key] = [
                                'item_code' => $itemCode,
                                'size' => $size,
                                'qty' => $qty
                                ];
                                } else {
                                $groupedCorrugationData[$key]['qty'] += $qty;
                                }
                                }
                                ?>

                                <table id="combined-data-table-corrugation"
    class="table table-striped dt-responsive nowrap w-100">
    <h4 for="corrugation">Corrugation Purchase Details</h4>
    <thead>
        <tr>
            <th>Corrugation Type</th>
            <th>Size</th>
            <th>Qty</th>
            
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $corrugationData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($data->item_name); ?></td>
            <td><?php echo e($data->size); ?></td>
            <td><?php echo e($data->remain_qty); ?></td>
            
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>



                                <?php elseif($productType == 'SPN'): ?>
                                 <?php
                                $groupedShipperData = [];
                                foreach ($trndtl7 as $data) {
                                $itemCode = $data->shipperpurchases->items->item_code ?? 'N/A';
                                $qty = $data->shipperpurchases->qty ?? 0;

                                if (!isset($groupedShipperData[$itemCode])) {
                                $groupedShipperData[$itemCode] = $qty;
                                } else {
                                $groupedShipperData[$itemCode] += $qty;
                                }
                                }
                                ?>

                                <table id="combined-data-table-shipper"
       class="table table-striped dt-responsive nowrap w-100">
    <h4 for="shipper">Shipper Purchase Details</h4>
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $shipperData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemshipper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($itemshipper->item); ?></td>
                <td><?php echo e($itemshipper->remain_qty); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>








   <?php elseif($productType == 'DPN'): ?>


<table id="combined-data-table-dye"
       class="table table-striped dt-responsive nowrap w-100">
    <h4 for="dye">Dye Purchase Details</h4>
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $dyeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dye): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($dye->item_name  ?? 'N/A'); ?></td>
                <td><?php echo e($dye->remain_qty  ?? 'N/A'); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>




                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Set default dates
const today = new Date();
document.getElementById('end_date').valueAsDate = today;

function printTable() {
    // Get the current page title
    const pageTitle = document.querySelector('.page-title').innerText;
    
    // Get search criteria
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const productType = document.getElementById('product_type').value;
    
    // Create a print window
    const printWindow = window.open('', '_blank');
    
    // Create print header with search criteria
    let printContent = `
        <html>
            <head>
                <title>${pageTitle}</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    .print-header {
                        text-align: center;
                        margin-bottom: 20px;
                        border-bottom: 1px solid #ddd;
                        padding-bottom: 10px;
                    }
                    .print-header h2 {
                        margin: 0;
                        font-size: 18px;
                    }
                    .print-header div {
                        margin: 5px 0;
                        font-size: 12px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                        font-size: 12px;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 6px;
                        text-align: left;
                    }
                    th {
                        background-color: #f2f2f2;
                        font-weight: bold;
                    }
                    .section-title {
                        font-weight: bold;
                        margin: 15px 0 5px 0;
                        font-size: 14px;
                    }
                    @page {
                        size: auto;
                        margin: 10mm;
                    }
                    @media print {
                        body {
                            margin: 0;
                            padding: 0;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="print-header">
                    <h2>${pageTitle}</h2>
                    <div><strong>Date:</strong> ${startDate} to ${endDate}</div>
    `;
    
    if (productType) {
        const typeText = document.querySelector(`#product_type option[value="${productType}"]`).text;
        printContent += `<div><strong>Type:</strong> ${typeText}</div>`;
    }
    
    printContent += `</div>`;
    
    // Get all visible tables
    const visibleTables = document.querySelectorAll('table[id^="combined-data-table-"]');
    
    // If no specific product type is selected, print all tables with their headings
    if (!productType) {
        visibleTables.forEach(table => {
            const heading = table.previousElementSibling;
            if (heading && heading.tagName === 'H4') {
                printContent += `<div class="section-title">${heading.innerText}</div>`;
            }
            printContent += table.outerHTML;
        });
    } else {
        // If specific product type is selected, print just that table
        const tableId = `combined-data-table-${productType.toLowerCase().substring(1)}`;
        const table = document.getElementById(tableId);
        if (table) {
            const heading = table.previousElementSibling;
            if (heading && heading.tagName === 'H4') {
                printContent += `<div class="section-title">${heading.innerText}</div>`;
            }
            printContent += table.outerHTML;
        }
    }
    
    printContent += `</body></html>`;
    
    // Write content to print window
    printWindow.document.open();
    printWindow.document.write(printContent);
    printWindow.document.close();
    
    // Wait for content to load before printing
    printWindow.onload = function() {
        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 200);
    };
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/report_stock/index.blade.php ENDPATH**/ ?>