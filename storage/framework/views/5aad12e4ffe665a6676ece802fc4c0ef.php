<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
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
                    <h4 class="page-title">Add Department</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="input-types-preview">
                                <div class="row">
                                    <div class="col-lg-6">
                                       <form action="<?php echo e(route('print.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="mb-3">
        <label for="type_title" class="form-label">Name</label>
        <input type="text" id="type_title" class="form-control" name="type_title"
               value="<?php echo e(old('type_title')); ?>" placeholder="Name" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>


                                    </div>
                                </div>
                            </div>
                       </div>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/realerp/public_html/probox/resources/views/print/list.blade.php ENDPATH**/ ?>