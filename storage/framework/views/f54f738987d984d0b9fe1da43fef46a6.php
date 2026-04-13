<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Form Elements</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Add Item Type</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->



        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                      


                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form action="<?php echo e(route('inventory.itemtype')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>

                                            <div class="mb-3">
                                                <label for="type_title" class="form-label">Item Title</label>
                                                <input type="text" id="type_title" class="form-control" name="type_title"
                                                    value="<?php echo e(old('type_title')); ?>" placeholder="Item Title" required>

                                                <!-- Display validation error for 'type_title' -->
                                                <?php if($errors->has('type_title')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('type_title')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>

                                    </div> <!-- end col -->


                                </div>
                                <!-- end row-->
                            </div> <!-- end preview-->


                        </div> <!-- end tab-content-->

                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/inventory/create_item_type.blade.php ENDPATH**/ ?>