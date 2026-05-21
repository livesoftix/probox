<?php $__env->startPush('styles'); ?>
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
        .print-only {
            display: none;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .print-only {
                display: table-row !important;
            }

            .panel-heading,
            .page-wrapper .container-fluid>.row:first-child {
                display: none;
            }
        }

        .select2-container .select2-selection--single {
            height: 34px;
        }

        .table>tbody>tr>td {
            vertical-align: middle;
        }

        .mr-25 {
            margin-right: 10px;
        }

        .btn-link {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .btn-link:hover {
            opacity: 0.7;
        }

        .fa-eye {
            font-size: 16px;
            color: #17a2b8;
        }

        .fa-pencil {
            font-size: 16px;
            color: #ffc107;
        }

        .fa-close {
            font-size: 16px;
            color: #dc3545;
        }

        .fa-eye:hover,
        .fa-pencil:hover,
        .fa-close:hover {
            opacity: 0.8;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- start page title -->
    <div class="row heading-bg" style="display:flex; align-items:center; padding:10px 15px; margin-bottom:10px;">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="display:flex; align-items:center;">
            <h5 class="txt-primary" style="margin:0; font-weight:700; font-size:15px; letter-spacing:0.3px;">
                &nbsp;Stock Adjustments
            </h5>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"
            style="display:flex; align-items:center; justify-content:flex-end;">
            <ol class="breadcrumb" style="margin:0; padding:0; background:none; font-size:12px;">
                <li><a href="<?php echo e(url('/admin/dashboard')); ?>">Dashboard</a></li>
                <li class="active"><span class="txt-primary">Stock Adjustments</span></li>
            </ol>
        </div>
    </div>
    <!-- end page title -->

    <!-- Search Form Panel -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Filter Stock Adjustments</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="">
                    <div class="panel-body">
                        <form action="<?php echo e(route('stock-adj.index')); ?>" method="GET" id="search-form">
                            <div class="row">

                                <!-- Item Name -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">Item Name</label>
                                        <select name="item_id" class="form-control select2" data-toggle="select2">
                                            <option value="">Select Item</option>
                                            <?php if(isset($items) && $items->count()): ?>
                                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->id); ?>" <?php echo e(request()->get('item_id') == $item->id ? 'selected' : ''); ?>>
                                                        <?php echo e(str_replace('\\', '/', $item->item_name ?? $item->item_code) . '-' . ($item->urdu_title ?? '')); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Voucher No -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">Voucher No</label>
                                        <select name="voucher_no" class="form-control select2" data-toggle="select2">
                                            <option value="">Select Voucher No</option>
                                            <?php if(isset($voucherList) && $voucherList->count()): ?>
                                                <?php $__currentLoopData = $voucherList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($voucher->v_no); ?>" <?php echo e(request()->get('voucher_no') == $voucher->v_no ? 'selected' : ''); ?>>
                                                        <?php echo e($voucher->v_no); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Start Date -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">Start Date</label>
                                        <input type="date" class="form-control" name="start_date"
                                            value="<?php echo e(request()->get('start_date')); ?>" autocomplete="off">
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">End Date</label>
                                        <input type="date" class="form-control" name="end_date"
                                            value="<?php echo e(request()->get('end_date') ?? now()->format('Y-m-d')); ?>"
                                            autocomplete="off">
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="col-md-12 mt-15">
                                    <button type="submit" class="btn btn-primary">Show</button>
                                    <a href="<?php echo e(route('stock-adj.create')); ?>" class="btn btn-success">Add Adjustment</a>
                                    <a href="<?php echo e(route('stock-adj.index')); ?>" class="btn btn-secondary">Clear</a>
<button type="button" class="btn btn-secondary" onclick="window.print()">Print</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session('success')): ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php echo e(session('success')); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php echo e(session('error')); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Adjustments Table Panel -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="">
                    <div class="panel-body">
                        <div class="table-wrap mt-30">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered mb-0">
                                    <thead>

                                        <th>Voucher No</th>
                                        <th>Voucher Date</th>
                                        <th>Item Name</th>
                                        <th class="no-print">Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = isset($masters) && $masters->count() ? $masters : []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php $__currentLoopData = $master->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="fw-bold"><?php echo e($master->v_no); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($master->v_date)->format('d-M-Y')); ?></td>
                                                    <td><?php echo e($detail->item->item_name ?? $detail->item->item_code ?? 'N/A'); ?></td>
                                                    <td class="no-print text-nowrap">
                                                        <!-- View Details -->
                                                        <a href="<?php echo e(route('stock-adj.show', $master->id)); ?>" class="mr-25"
                                                            data-toggle="tooltip" title="View">
                                                            <i class="fa fa-eye text-info"></i>
                                                        </a>
                                                        <!-- Edit -->
                                                        <a href="<?php echo e(route('stock-adj.edit', $master->id)); ?>" class="mr-25"
                                                            data-toggle="tooltip" title="Edit">
                                                            <i class="fa fa-pencil text-inverse"></i>
                                                        </a>
                                                        <!-- Delete -->
                                                        <form action="<?php echo e(route('stock-adj.destroy', $master->id)); ?>" method="POST"
                                                            style="display:inline-block;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-link p-0"
                                                                onclick="return confirm('Are you sure you want to delete voucher <?php echo e($master->v_no); ?>?')"
                                                                data-toggle="tooltip" title="Delete">
                                                                <i class="fa fa-close text-danger"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    No stock adjustments found.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php if(isset($masters) && method_exists($masters, 'links')): ?>
        <div class="row mt-3">
            <div class="col-sm-12 text-center">
                <?php echo e($masters->links()); ?>

            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(function () {
            // Initialize Select2
            $('.select2').select2();

            // Dismiss alerts
            $('.alert .close').on('click', function () {
                $(this).closest('.alert').fadeOut();
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/stock-adj/index.blade.php ENDPATH**/ ?>