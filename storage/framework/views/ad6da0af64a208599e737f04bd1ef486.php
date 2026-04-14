<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Disposable Purchase (Create)</h4>
                </div>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="voucherForm" action="<?php echo e(route('disposable_purchase.store')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="v_type" value="DSPN">

                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" id="date" name="date" class="form-control" value="<?php echo e(old('date', \Carbon\Carbon::now()->toDateString())); ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="preparedBy" class="form-label">Prepared By</label>
                                        <input type="text" id="preparedBy" class="form-control" value="<?php echo e($loggedInUser->name ?? auth()->user()->name ?? ''); ?>" name="prepared_by" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="supplier" class="form-label">Supplier</label>
                                        <select name="supplier" id="supplier" class="form-control select2" data-toggle="select2" required>
                                            <option value="">Select</option>
                                            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="item_id" class="form-label">Item</label>
                                        <select id="item_id" class="form-control select2" data-toggle="select2">
                                            <option value="">Select</option>
                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->id); ?>" data-rate="<?php echo e($item->purchase ?? $item->rate ?? 0); ?>"><?php echo e($item->item_code); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="qty" class="form-label">Quantity</label>
                                        <input type="number" step="any" id="qty" class="form-control" placeholder="Quantity">
                                    </div>

                                    <div class="mb-3">
                                        <label for="weight_type" class="form-label">Weight Type</label>
                                        <select id="weight_type" class="form-control">
                                            <option value="">Select</option>
                                            <option value="kg">kg</option>
                                            <option value="litre">litre</option>
                                            <option value="ml">ml</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="rate" class="form-label">Rate</label>
                                        <input type="number" step="any" id="rate" class="form-control" placeholder="Rate">
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" id="image" class="form-control" accept="image/*">
                                    </div>

                                    <div class="mb-3">
                                        <button type="button" id="addEntry" class="btn btn-primary">Add Entry</button>
                                        <button type="submit" class="btn btn-success">Submit Voucher</button>
                                    </div>


                                    <input type="hidden" id="totalAmount" name="total_amount" value="0">
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="entriesTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item</th>
                                                    <th>Qty</th>
                                                    <th>Weight</th>
                                                    <th>Rate</th>
                                                    <th>Amount</th>
                                                    <th>Image</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="entriesBody">
                                                <!-- dynamic rows -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            // When item changes, set rate automatically if data-rate present
            $('#item_id').on('change', function() {
                var rate = $(this).find('option:selected').data('rate');
                if (rate !== undefined) {
                    $('#rate').val(rate);
                }
            });

            function formatNumber(n) {
                return Math.round(n * 100) / 100;
            }

            $('#addEntry').on('click', function() {
                var itemSelect = $('#item_id');
                var itemId = itemSelect.val();
                var itemText = itemSelect.find('option:selected').text();
                var qty = parseFloat($('#qty').val());
                var weight = $('#weight_type').val();
                var rate = parseFloat($('#rate').val());
                var imageFile = $('#image')[0].files[0];

                if (!itemId || isNaN(qty) || !weight || isNaN(rate)) {
                    alert('Please fill Item, Quantity, Weight Type and Rate before adding an entry.');
                    return;
                }

                var amount = qty * rate;
                var uniqueId = Date.now();
                var rowCount = $('#entriesBody tr').length + 1;

                var imagePreview = imageFile ? '<img src="' + URL.createObjectURL(imageFile) + '" style="width:50px;height:50px;object-fit:cover;">' : 'No Image';
                
                var row = '<tr data-id="' + uniqueId + '">' +
                    '<td>' + rowCount + '</td>' +
                    '<td>' + $('<div>').text(itemText).html() + '</td>' +
                    '<td>' + qty + '</td>' +
                    '<td>' + weight + '</td>' +
                    '<td>' + formatNumber(rate) + '</td>' +
                    '<td>' + formatNumber(amount) + '</td>' +
                    '<td>' + imagePreview + '</td>' +
                    '<td>' +
                        '<button type="button" class="btn btn-sm btn-danger btn-delete">Delete</button>' +
                        '<input type="hidden" name="entries[' + uniqueId + '][item_id]" value="' + itemId + '">' +
                        '<input type="hidden" name="entries[' + uniqueId + '][qty]" value="' + qty + '">' +
                        '<input type="hidden" name="entries[' + uniqueId + '][weight_type]" value="' + weight + '">' +
                        '<input type="hidden" name="entries[' + uniqueId + '][rate]" value="' + rate + '">' +
                        '<input type="hidden" name="entries[' + uniqueId + '][supplier]" value="' + $('#supplier').val() + '">' +
                    '</td>' +
                '</tr>';

                var $row = $(row);
                
                // Handle image file if present
                if (imageFile) {
                    var fileInput = $('<input type="file" name="entries[' + uniqueId + '][image]" style="display:none;">');
                    var dt = new DataTransfer();
                    dt.items.add(imageFile);
                    fileInput[0].files = dt.files;
                    $row.find('td:last').append(fileInput);
                }

                $('#entriesBody').append($row);

                // Lock supplier and date after first entry
                $('#supplier').prop('disabled', true);
                $('#date').prop('disabled', true);

                // Update total
                var totalField = $('#totalAmount');
                totalField.val( parseFloat(totalField.val() || 0) + amount );

                // Clear inputs for next entry
                $('#item_id').val('').trigger('change');
                $('#qty').val('');
                $('#weight_type').val('');
                $('#rate').val('');
                $('#image').val('');
            });

            // Delegate delete
            $('#entriesBody').on('click', '.btn-delete', function() {
                var row = $(this).closest('tr');
                var amount = parseFloat(row.find('td').eq(5).text()) || 0;
                row.remove();

                // Re-number rows
                $('#entriesBody tr').each(function(i) {
                    $(this).find('td').first().text(i + 1);
                });

                // Update total
                var totalField = $('#totalAmount');
                totalField.val( Math.max(0, parseFloat(totalField.val() || 0) - amount) );

                if ($('#entriesBody tr').length === 0) {
                    $('#supplier').prop('disabled', false);
                    $('#date').prop('disabled', false);
                }
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/disposable_purchase/list.blade.php ENDPATH**/ ?>