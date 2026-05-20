<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Softix</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Edit Confectionery</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Confectionery</h4>
                </div>
            </div>
        </div>
        <!-- End page title -->

        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">

                                <form id="voucherForm" action="<?php echo e(route('confectionery.update', $voucher->first()->v_no)); ?>"
                                    method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <button type="button" id="addEntry" class="btn btn-primary">Add Entry</button>
                                        <button type="submit" class="btn btn-success">Submit Voucher</button>
                                        <div class="ms-3">
                                            <label class="form-label mb-0 me-1">Voucher Date:</label>
                                            <input type="date" id="voucherDate" class="form-control d-inline-block"
                                                style="width:auto;"
                                                value="<?php echo e(optional($voucher->first())->date ? \Carbon\Carbon::parse(optional($voucher->first())->date)->format('Y-m-d') : ''); ?>">
                                        </div>
                                    </div>
                                    <div style="overflow-x:auto;">
                                        <table class="table table-sm table-bordered align-middle mt-4" id="entriesTable"
                                            style="min-width:1200px; font-size: 0.92rem;">
                                            <thead>
                                                <tr style="white-space:nowrap;">
                                                    <th style="min-width:40px;">Sr No</th>
                                                    <th style="min-width:110px;">Date</th>
                                                    <th style="min-width:180px;">Product Name</th>
                                                    <th style="min-width:180px;">Account Title</th>
                                                    <th style="min-width:160px;">Item Title</th>
                                                    <th style="min-width:110px;">CTN</th>
                                                    <th style="min-width:110px;">Pack Qty</th>
                                                    <th style="min-width:110px;">PO No</th>
                                                    <th style="min-width:110px;">Rate</th>
                                                    <th style="min-width:110px;">Total</th>
                                                    <th style="min-width:110px;">Freight</th>
                                                    <th style="min-width:150px;">Driver Name</th>
                                                    <th style="min-width:150px;">Vehicle Number</th>
                                                    <th style="min-width:90px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="entriesBody">
                                                <?php $totalEntries = 0; ?>
                                                <?php if($voucher->isNotEmpty()): ?>
                                                    <?php $__currentLoopData = $voucher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trndtl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             
                                                        <tr data-entry-id="<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>">
                                                            <td><?php echo e(++$totalEntries); ?></td>
                                                            <td>
                                                                <input type="date"
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][date]"
                                                                    class="form-control"
                                                                    value="<?php echo e(isset($trndtl->date) ? \Carbon\Carbon::parse($trndtl->date)->format('Y-m-d') : ''); ?>"
                                                                    readonly>
                                                                <input type="hidden"
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][id]"
                                                                    value="<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>">
                                                            </td>
                                                            <td>
                                                                <select
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][product]"
                                                                    class="form-control select2">
                                                                    <option value="">Select</option>
                                                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($prod->id); ?>"
                                                                            <?php if(($trndtl->confectionerydetails->products->id ?? null) == $prod->id): ?> selected <?php endif; ?>>
                                                                            <?php echo e($prod->prod_name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                                <input type="hidden"
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][orig_product]"
                                                                    value="<?php echo e($trndtl->confectionerydetails->products->id ?? ''); ?>">
                                                            </td>
                                                            <td>
                                                                <select
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][supplier]"
                                                                    class="form-control select2" required>
                                                                    <option value="">Select</option>
                                                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($account->id); ?>"
                                                                            <?php if(($trndtl->accounts->id ?? null) == $account->id): ?> selected <?php endif; ?>>
                                                                            <?php echo e($account->title); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][item]"
                                                                    class="form-control select2">
                                                                    <option value="">Select</option>
                                                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($item->id); ?>"
                                                                            <?php if(($trndtl->confectionerydetails->itemType->id ?? null) == $item->id): ?> selected <?php endif; ?>>
                                                                            <?php echo e($item->type_title); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                                <input type="hidden"
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][orig_item]"
                                                                    value="<?php echo e($trndtl->confectionerydetails->itemType->id ?? ''); ?>">
                                                            </td>
                                                            <td><input type="number"
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][box]"
                                                                    class="form-control"
                                                                    value="<?php echo e($trndtl->confectionerydetails->box ?? ''); ?>">
                                                            </td>
                                                            <td><input type="number"
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][packing]"
                                                                    class="form-control"
                                                                    value="<?php echo e($trndtl->confectionerydetails->pack_qty ?? ''); ?>">
                                                            </td>
                                                            <td><input type="text"
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][po_no]"
                                                                    class="form-control"
                                                                    value="<?php echo e($trndtl->confectionerydetails->po_no ?? ''); ?>">
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01"
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][rate]"
                                                                    class="form-control rate-input"
                                                                    value="<?php echo e($trndtl->confectionerydetails->rate ?? ''); ?>"
                                                                    readonly>
                                                            </td>
                                                            <td><input type="number" step="0.01"
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][total]"
                                                                    class="form-control entry-total"
                                                                    value="<?php echo e($trndtl->confectionerydetails->total ?? ''); ?>"
                                                                    readonly></td>
                                                            <td><input type="number"
                                                                    name="entries[<?php echo e($trndtl->confectionerydetails->id ?? ''); ?>][freight]"
                                                                    class="form-control"
                                                                    value="<?php echo e($trndtl->confectionerydetails->freight ?? 0); ?>">
                                                            </td>
                                                            <td>
    <input type="text"
    name="delivery_name"
    class="form-control"
    value="<?php echo e($deliveryDetails->driver_name ?? ''); ?>">
</td>
<td>
   <input type="text"
    name="vehicle_number"
    class="form-control"
    value="<?php echo e($deliveryDetails->vehicle_number ?? ''); ?>">
</td>
                                                            <td>
                                                                <?php if(isset($hasBilling) && $hasBilling): ?>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        disabled
                                                                        title="Remove billings first">Delete</button>
                                                                <?php else: ?>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm delete-entry">Delete</button>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="9" style="text-align: right;"><strong>Grand
                                                            Total:</strong></td>
                                                    <td id="grandTotal">0</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </form>
                            </div> <!-- End preview-->
                        </div> <!-- End tab-content-->
                    </div> <!-- End card-body -->
                </div> <!-- End card -->
            </div><!-- End col -->
        </div><!-- End row -->
    </div> <!-- End container -->

    <!-- jQuery (Required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const entriesTable = document.getElementById('entriesBody');
            const addEntryButton = document.getElementById('addEntry');
            let deletedIds = [];

            // Build ProductMaster rate maps for quick lookup
            const productRates = <?php echo json_encode(
                $products->mapWithKeys(function ($p) {
                        return [$p->id => (float) ($p->rate ?? 0)];
                    })->toArray(), 15, 512) ?>;
            const itemRates = <?php echo json_encode(
                $products->groupBy('item_id')->map(function ($grp) {
                        return (float) ($grp->first()->rate ?? 0);
                    })->toArray(), 15, 512) ?>;

            function updateRateForRow(row) {
                const $row = $(row);
                const productId = $row.find('select[name^="entries"][name$="[product]"]').val();
                const itemId = $row.find('select[name^="entries"][name$="[item]"]').val();
                let rate = 0;
                if (productId && productRates[productId] !== undefined) {
                    rate = productRates[productId] || 0;
                } else if (itemId && itemRates[itemId] !== undefined) {
                    rate = itemRates[itemId] || 0;
                }
                $row.find('input[name^="entries"][name$="[rate]"]').val(rate);
            }

            function initializeDeleteButtons() {
                entriesTable.querySelectorAll('.delete-entry').forEach(function(btn) {
                    btn.onclick = function() {
                        <?php if(isset($hasBilling) && $hasBilling): ?>
                            alert(
                                'Please remove the associated billings first before deleting entries.');
                            return;
                        <?php else: ?>
                            const row = btn.closest('tr');
                            const entryId = row.getAttribute('data-entry-id');
                            if (entryId) {
                                deletedIds.push(entryId);
                                let input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'deleted_ids[]';
                                input.value = entryId;
                                document.getElementById('voucherForm').appendChild(input);
                            }
                            row.remove();
                        <?php endif; ?>
                    };
                });
            }

            if (addEntryButton) {
                addEntryButton.addEventListener('click', function() {
                    const uniqueKey = 'new_' + Date.now();
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                    <td>New</td>
                    <td><input type="date" name="entries[${uniqueKey}][date]" class="form-control" value="<?php echo e(optional($voucher->first())->date ? \Carbon\Carbon::parse(optional($voucher->first())->date)->format('Y-m-d') : ''); ?>"></td>
                    <td>
                        <select name="entries[${uniqueKey}][product]" class="form-control select2">
                            <option value="">Select</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($prod->id); ?>"><?php echo e($prod->prod_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td>
                        <select name="entries[${uniqueKey}][supplier]" class="form-control select2">
                            <option value="">Select</option>
                            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($account->id); ?>"><?php echo e($account->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td>
                        <select name="entries[${uniqueKey}][item]" class="form-control select2">
                            <option value="">Select</option>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->type_title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td><input type="number" name="entries[${uniqueKey}][box]" class="form-control"></td>
                    <td><input type="number" name="entries[${uniqueKey}][packing]" class="form-control"></td>
                    <td><input type="text" name="entries[${uniqueKey}][po_no]" class="form-control"></td>
                    <td><input type="number" step="0.01" name="entries[${uniqueKey}][rate]" class="form-control rate-input" readonly></td>
                    <td><input type="number" step="0.01" name="entries[${uniqueKey}][total]" class="form-control entry-total" readonly></td>
                    <td><input type="number" name="entries[${uniqueKey}][freight]" class="form-control" value="0"></td>
                    <td><input type="text" name="entries[${uniqueKey}][driver_name]" class="form-control"></td>

<td><input type="text" name="entries[${uniqueKey}][vehicle_number]" class="form-control"></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-entry">Delete</button></td>
                `;
                    entriesTable.appendChild(newRow);
                    initializeDeleteButtons();
                    $(newRow).find('.select2').select2();
                    // Initialize rate based on default selections (if any)
                    updateRateForRow(newRow);
                    recalcRowTotal(newRow);
                    recalcAll();
                });
            }

            function recalcRowTotal(row) {
                const box = parseFloat($(row).find('input[name^="entries"][name$="[box]"]').val()) || 0;
                const pack = parseFloat($(row).find('input[name^="entries"][name$="[packing]"]').val()) || 0;
                const rate = parseFloat($(row).find('input[name^="entries"][name$="[rate]"]').val()) || 0;
                const total = box * pack * rate;
                $(row).find('.entry-total').val(total.toFixed(2));
            }

            function recalcAll() {
                let grand = 0;
                $('#entriesBody tr').each(function() {
                    recalcRowTotal(this);
                    const total = parseFloat($(this).find('.entry-total').val()) || 0;
                    grand += total;
                });
                $('#grandTotal').text(grand.toFixed(2));
            }

            function bindCalcHandlers() {
                $('#entriesBody').on('input',
                    'input[name$="[box]"], input[name$="[packing]"], input[name$="[rate]"]',
                    function() {
                        const row = $(this).closest('tr');
                        recalcRowTotal(row);
                        recalcAll();
                    });
                $('#entriesBody').on('change', 'select[name$="[product]"], select[name$="[item]"]', function() {
                    const row = $(this).closest('tr');
                    updateRateForRow(row);
                    recalcRowTotal(row);
                    recalcAll();
                });
            }

            initializeDeleteButtons();
            bindCalcHandlers();
            // On load, enforce ProductMaster rates for all existing rows
            $('#entriesBody tr').each(function() {
                updateRateForRow(this);
            });
            recalcAll();

            // Bulk date setter
            const voucherDate = document.getElementById('voucherDate');
            if (voucherDate) {
                voucherDate.addEventListener('change', function() {
                    const val = this.value;
                    if (!val) return;
                    $('#entriesBody input[name^="entries"][name$="[date]"]').each(function() {
                        this.value = val;
                    });
                });
            }
        });

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/sale_reports/edit5.blade.php ENDPATH**/ ?>