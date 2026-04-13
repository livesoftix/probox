 
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
                            <li class="breadcrumb-item active">Edit Purchase Invoice</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Pharmaceutical</h4>
                </div>
            </div>
        </div>
        <!-- End page title -->

        <!-- Display any error messages -->
        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <div id="clientAlert" class="alert alert-danger d-none"></div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">
                                <div class="row">
                                    <form id="voucherForm"
                                          action="<?php echo e(route('delivery_challan.update', $voucher->first()->v_no)); ?>"
                                          method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>

                                        <div class="col-6 mb-2">
                                            <input type="hidden" name="v_type" value="PIN">
                                            <input type="hidden" name="invoice_number">
                                            <input type="hidden" id="totalAmount" name="total_amount">
                                            <input type="hidden" id="totalWeight" name="total_weight">

                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" id="addEntry" class="btn btn-primary">Add Entry</button>
                                                <button type="submit" class="btn btn-success">Submit Voucher</button>
                                                <div class="ms-3">
                                                    <label class="form-label mb-0 me-1">Voucher Date:</label>
                                                    <input type="date" id="voucherDate" class="form-control d-inline-block" style="width:auto;" value="<?php echo e(optional($voucher->first())->date ? \Carbon\Carbon::parse(optional($voucher->first())->date)->format('Y-m-d') : ''); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Entries Table -->
                                        <div class="col-lg-12">
                                            <div style="overflow-x:auto;">
                                                <table class="table table-sm table-bordered align-middle mt-4"
                                                       id="entriesTable"
                                                       style="min-width:1200px; font-size: 0.92rem;">
                                                    <thead>
                                                        <tr style="white-space:nowrap;">
                                                            <th>Sr No</th>
                                                            <th>Date</th>
                                                            <th>Product Name</th>
                                                            <th>Account Title</th>
                                                            <th style="min-width:70px;">Item Title</th>
                                                            <th style="min-width:110px;">CTN</th>
                                                            <th style="min-width:110px;">Pack Qty</th>
                                                            <th style="min-width:110px;">Batch No</th>
                                                            <th style="min-width:110px;">Total</th>
                                                            <th style="min-width:110px;">Amount</th>
                                                            <th style="min-width:70px;">Freight</th>
                                                            <th style="min-width:110px;">Rate</th>
                                                            <th style="min-width:70px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="entriesBody">
                                                        <?php $totalEntries = 0; ?>
                                                        <?php if($voucher->isNotEmpty()): ?>
                                                            <?php $__currentLoopData = $voucher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trndtl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php 
                                                                    $entryId = $trndtl->deliverydetails->id ?? null; 
                                                                    $isBilled = isset($billed[$entryId]) && $billed[$entryId];
                                                                ?>
                                                                <tr data-entry-id="<?php echo e($entryId); ?>" data-billed="<?php echo e($isBilled ? '1' : '0'); ?>">
                                                                    <td><?php echo e(++$totalEntries); ?></td>
                                                                    <td>
                                                                        <input type="date"
                                                                               name="entries[<?php echo e($entryId); ?>][date]"
                                                                               class="form-control"
                                                                               value="<?php echo e(isset($trndtl->date) ? \Carbon\Carbon::parse($trndtl->date)->format('Y-m-d') : ''); ?>" readonly>
                                                                        <input type="hidden"
                                                                               name="entries[<?php echo e($entryId); ?>][id]"
                                                                               value="<?php echo e($entryId); ?>">
                                                                    </td>
                                                                    <td>
                                                                        <select name="entries[<?php echo e($entryId); ?>][product]"
                                                                                class="form-control select2">
                                                                            <option value="">Select</option>
                                                                            <?php $__currentLoopData = $product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value="<?php echo e($prod->id); ?>"
                                                                                    <?php if(($trndtl->deliverydetails->products->id ?? null) == $prod->id): ?> selected <?php endif; ?>>
                                                                                    <?php echo e($prod->prod_name); ?>

                                                                                </option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>
                                                                        <input type="hidden"
                                                                               name="entries[<?php echo e($entryId); ?>][orig_product]"
                                                                               value="<?php echo e($trndtl->deliverydetails->products->id ?? ''); ?>">
                                                                    </td>
                                                                    <td>
                                                                        <select name="entries[<?php echo e($entryId); ?>][supplier]"
                                                                                class="form-control select2" required>
                                                                            <option value="">Select</option>
                                                                            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value="<?php echo e($account->id); ?>"
                                                                                    <?php if(($trndtl->accounts->id ?? null) == $account->id): ?> selected <?php endif; ?>>
                                                                                    <?php echo e($account->title); ?>

                                                                                </option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select name="entries[<?php echo e($entryId); ?>][item]"
                                                                                class="form-control select2">
                                                                            <option value="">Select</option>
                                                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value="<?php echo e($item->id); ?>"
                                                                                    <?php if(($trndtl->deliverydetails->itemType->id ?? null) == $item->id): ?> selected <?php endif; ?>>
                                                                                    <?php echo e($item->type_title); ?>

                                                                                </option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>
                                                                        <input type="hidden"
                                                                               name="entries[<?php echo e($entryId); ?>][orig_item]"
                                                                               value="<?php echo e($trndtl->deliverydetails->itemType->id ?? ''); ?>">
                                                                    </td>
                                                                    <td><input type="number" name="entries[<?php echo e($entryId); ?>][box]"
                                                                               class="form-control"
                                                                               value="<?php echo e($trndtl->deliverydetails->box ?? ''); ?>"></td>
                                                                    <td><input type="number" name="entries[<?php echo e($entryId); ?>][packing]"
                                                                               class="form-control"
                                                                               value="<?php echo e($trndtl->deliverydetails->pack_qty ?? ''); ?>"></td>
                                                                    <td><input type="text" name="entries[<?php echo e($entryId); ?>][batchNo]"
                                                                               class="form-control"
                                                                               value="<?php echo e($trndtl->deliverydetails->batch_no ?? ''); ?>"></td>
                                                                    <td><input type="number" step="0.01"
                                                                               name="entries[<?php echo e($entryId); ?>][total]"
                                                                               class="form-control entry-total"
                                                                               value="<?php echo e($trndtl->deliverydetails->total ?? ''); ?>"
                                                                               readonly></td>
                                                                    <td><input type="number" step="0.01"
                                                                               name="entries[<?php echo e($entryId); ?>][amount]"
                                                                               class="form-control entry-amount"
                                                                               value="<?php echo e($trndtl->deliverydetails->box * $trndtl->deliverydetails->pack_qty); ?>"
                                                                               readonly></td>
                                                                    <td><input type="number"
                                                                               name="entries[<?php echo e($entryId); ?>][freight]"
                                                                               class="form-control"
                                                                               value="<?php echo e($trndtl->deliverydetails->freight ?? 0); ?>"></td>
                                                                    <td>
                                                                        <input type="number" step="0.01"
                                                                               name="entries[<?php echo e($entryId); ?>][rate]"
                                                                               class="form-control entry-rate"
                                                                               value="<?php echo e($trndtl->deliverydetails->products->sale_rate ?? $trndtl->deliverydetails->products->rate ?? 0); ?>" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-danger btn-sm delete-entry" <?php if($isBilled): ?> disabled title="This entry has a related bill and cannot be deleted" <?php endif; ?>>Delete</button>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="8" class="text-end"><strong>Grand Total:</strong></td>
                                                            <td id="grandTotal">0</td>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- End row-->
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
            $product->mapWithKeys(function ($p) {
                    return [$p->id => (float) ($p->sale_rate ?? $p->rate ?? 0)];
                })->toArray(), 15, 512) ?>;
        const itemRates = <?php echo json_encode(
            $product->groupBy('item_id')->map(function ($grp) {
                    return (float) ($grp->first()->sale_rate ?? $grp->first()->rate ?? 0);
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

        function showTopAlert(message) {
            const banner = document.getElementById('clientAlert');
            if (!banner) return;
            banner.textContent = message;
            banner.classList.remove('d-none');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Add delete functionality
        function initializeDeleteButtons() {
            entriesTable.querySelectorAll('.delete-entry').forEach(function(btn) {
                btn.onclick = function() {
                    const row = btn.closest('tr');
                    // Guard: prevent deleting billed entries
                    if (row && row.getAttribute('data-billed') === '1') {
                        showTopAlert('To delete this voucher entry, delete its billing first.');
                        return;
                    }
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
                    recalcAll();
                };
            });
        }

        // Add new entry row
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
                            <?php $__currentLoopData = $product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                    <td><input type="text" name="entries[${uniqueKey}][batchNo]" class="form-control"></td>
                    <td><input type="number" step="0.01" name="entries[${uniqueKey}][total]" class="form-control entry-total" readonly></td>
                    <td><input type="number" step="0.01" name="entries[${uniqueKey}][amount]" class="form-control entry-amount" value="0" readonly></td>
                    <td><input type="number" name="entries[${uniqueKey}][freight]" class="form-control" value="0"></td>
                    <td><input type="number" step="0.01" name="entries[${uniqueKey}][rate]" class="form-control entry-rate" value="0" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-entry">Delete</button></td>
                `;
                entriesTable.appendChild(newRow);
                initializeDeleteButtons();
                $(newRow).find('.select2').select2();
                // Initialize rate based on default selections (if any)
                updateRateForRow(newRow);
                recalcRowAmount(newRow);
                recalcAll();
            });
        }

        // Recalculate row amount
        function recalcRowAmount(row) {
            const box = parseFloat($(row).find('input[name$="[box]"]').val()) || 0;
            const pack = parseFloat($(row).find('input[name$="[packing]"]').val()) || 0;
            const rate = parseFloat($(row).find('.entry-rate').val()) || 0;
            const total = box * pack;
            const amount = rate * total;
            $(row).find('.entry-total').val(total.toFixed(2));
            $(row).find('.entry-amount').val(amount.toFixed(2));
        }

        function recalcAll() {
            let grand = 0;
            $('#entriesBody tr').each(function() {
                recalcRowAmount(this);
                const amt = parseFloat($(this).find('.entry-amount').val()) || 0;
                grand += amt;
            });
            $('#grandTotal').text(grand.toFixed(2));
        }

        function bindCalcHandlers() {
            $('#entriesBody').on('input',
                'input[name$="[box]"], input[name$="[packing]"], input[name$="[rate]"]',
                function() {
                    const row = $(this).closest('tr');
                    recalcRowAmount(row);
                    recalcAll();
                });
            $('#entriesBody').on('change', 'select[name$="[product]"], select[name$="[item]"]', function() {
                const row = $(this).closest('tr');
                updateRateForRow(row);
                recalcRowAmount(row);
                recalcAll();
            });
        }

        // Initialize existing
        initializeDeleteButtons();
        bindCalcHandlers();
        // On load, enforce ProductMaster rates for all existing rows
        $('#entriesBody tr').each(function() {
            updateRateForRow(this);
        });
        recalcAll();
    });

    $(document).ready(function () {
        $('.select2').select2();
    });



    // Bulk date setter
    $(document).on('change', '#voucherDate', function(){
        var val = $(this).val();
        if (!val) return;
        $('#entriesBody input[name$="[date]"]').each(function(){
            $(this).val(val);
        });
    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/sale_reports/edit.blade.php ENDPATH**/ ?>