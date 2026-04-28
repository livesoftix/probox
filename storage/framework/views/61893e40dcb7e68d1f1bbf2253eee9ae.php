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
                    <h4 class="page-title">Edit Level2</h4>
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
                                        <form action="<?php echo e(route('level2.update', $level2->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="mb-3">
                                                <label for="simpleinput" class="form-label">Level2 Title</label>
                                                <input type="text" id="simpleinput" class="form-control" name="title"
                                                    value="<?php echo e(old('title', $level2->title)); ?>" placeholder="Level2 Title"
                                                    required>
                                                <?php if($errors->has('title')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="mb-3">
                                                <label for="department_id" class="form-label">Level1</label>
                                                <select name="level1_id" class="form-control select2" data-toggle="select2"
                                                    required>
                                                    <option>Select</option>
                                                    <?php $__currentLoopData = $level1s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($level1->id); ?>"
                                                            <?php echo e(old('level1_id', $level2->level1_id) == $level1->id ? 'selected' : ''); ?>>
                                                            <?php echo e($level1->title); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php if($errors->has('level1_id')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('level1_id')); ?></span>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/accounts/level2/edit.blade.php ENDPATH**/ ?>