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
                    <h4 class="page-title">Edit Chart Of Account</h4>
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
                                        <form action="<?php echo e(route('amaster.update', $account_masters->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="mb-3">
                                                <label for="simpleinput" class="form-label">Account Title</label>
                                                <input type="text" id="simpleinput" class="form-control" name="title"
                                                    value="<?php echo e(old('title', $account_masters->title)); ?>" required>
                                                <?php if($errors->has('title')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="mb-3">
                                                <label for="simpleinput" class="form-label">Opening Date</label>
                                                <input type="date" id="simpleinput" class="form-control"
                                                    name="opening_date"
                                                    value="<?php echo e(old('opening_date', $account_masters->opening_date)); ?>"
                                                    required>
                                                <?php if($errors->has('opening_date')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('opening_date')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="mb-3">
                                                <label for="department_id" class="form-label">Level2</label>
                                                <select name="level2_id" class="form-control select2" data-toggle="select2"
                                                    required>
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $level2s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($level2->id); ?>"
                                                            <?php echo e(old('level2_id', $account_masters->level2_id) == $level2->id ? 'selected' : ''); ?>>
                                                            <?php echo e($level2->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php if($errors->has('level2_id')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('level2_id')); ?></span>
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
        </div><!-- end row -->



    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/accounts/account_master/edit.blade.php ENDPATH**/ ?>