<?php $__env->startSection('content'); ?>
<div class="container pt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Job Detail</h2>
        <a href="<?php echo e(route('packaging-specs.create')); ?>" class="btn btn-success">
            <i class="fa fa-plus"></i> New Entry
        </a>
    </div>

    
    <div class="card shadow-sm mb-3">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-center">
                <!-- <div class="col-md-3">
                    <input type="date" name="date" class="form-control form-control-sm"
                           value="<?php echo e(request('date')); ?>" placeholder="Date">
                </div> -->
                <!-- <div class="col-md-3">
                    <input type="text" name="company_name"  class="form-control form-control-sm"
                           value="<?php echo e(request('company_name')); ?>" placeholder="Company Name">
                </div>
                <div class="col-md-3">
                    <input type="text" name="item_name" class="form-control form-control-sm"
                           value="<?php echo e(request('item_name')); ?>" placeholder="Item Name">
                </div> -->
                <div class="col-md-3 position-relative">
                    <div class="autocomplete-wrapper">
    <input type="text" id="company_name" name="company_name"
           class="form-control form-control-sm"
           value="<?php echo e(request('company_name')); ?>"
           placeholder="Company Name">
    <div id="company_suggestions" class="suggestion-box list-group position-absolute w-100"></div>
</div>
</div>

<div class="col-md-3 position-relative">
    <div class="autocomplete-wrapper">
    <input type="text" id="item_name" name="item_name"
           class="form-control form-control-sm"
           value="<?php echo e(request('item_name')); ?>"
           placeholder="Item Name">
    <div id="item_suggestions" class="suggestion-box list-group position-absolute w-100"></div>
</div>
</div>
                <!-- <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i class="fa fa-search"></i> Filter
                    </button>
                    <a href="<?php echo e(route('packaging-specs.index')); ?>" class="btn btn-outline-dark btn-sm">
                        Reset
                    </a>
                </div> -->
            </form>
        </div>
    </div>

    
    <div class="table-responsive">
        <table class="table table-sm table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Company</th>
                    <th>Item</th>
                    <th class="text-center" style="width: 140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $specs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e(\Carbon\Carbon::parse($spec->date)->format('d-m-Y')); ?></td>
                        <td><?php echo e($spec->company_name); ?></td>
                        <td><?php echo e($spec->item_name); ?></td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1 justify-content-center flex-nowrap">
                                <a href="<?php echo e(route('packaging-specs.show', $spec)); ?>" 
                                   class="btn btn-icon btn-light btn-sm" title="View">
                                    <i class="uil uil-eye text-primary"></i>
                                </a>
                                <a href="<?php echo e(route('packaging-specs.edit', $spec)); ?>" 
                                   class="btn btn-icon btn-light btn-sm" title="Edit">
                                    <i class="uil uil-edit text-warning"></i>
                                </a>
                                <a href="<?php echo e(route('packaging-specs.print', $spec)); ?>" 
                                   class="btn btn-icon btn-light btn-sm" title="Print" target="_blank">
                                    <i class="uil uil-print text-success"></i>
                                </a>
                                <form action="<?php echo e(route('packaging-specs.destroy', $spec)); ?>" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this packaging spec?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-icon btn-light btn-sm" title="Delete">
                                        <i class="uil uil-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No packaging specs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

   
    
</div>
<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function () {


  let selectedIndex = {
    company_name: -1,
    item_name: -1
};

    // replace your current keydown block with this

$(document).on('keydown', '#company_name, #item_name', function (e) {

    let input = $(this);
    let inputId = input.attr('id');

    let box = inputId === 'company_name'
        ? '#company_suggestions'
        : '#item_suggestions';

    let items = $(box).find('a');

    function highlightItem() {
        items.removeClass('active');

        if (selectedIndex[inputId] >= 0) {
            $(items[selectedIndex[inputId]]).addClass('active');
        }
    }

    if (e.keyCode === 40) { // DOWN
        e.preventDefault();
        if (items.length === 0) return;

        selectedIndex[inputId]++;

        if (selectedIndex[inputId] >= items.length) {
            selectedIndex[inputId] = 0;
        }

        highlightItem();
    }

    else if (e.keyCode === 38) { // UP
        e.preventDefault();
        if (items.length === 0) return;

        selectedIndex[inputId]--;

        if (selectedIndex[inputId] < 0) {
            selectedIndex[inputId] = items.length - 1;
        }

        highlightItem();
    }

    else if (e.keyCode === 13) { // ENTER
        if (selectedIndex[inputId] >= 0 && items.length > 0) {
            e.preventDefault();

            input.val($(items[selectedIndex[inputId]]).text());
            $(box).html('');
            selectedIndex[inputId] = -1;

            input.closest('form').submit();
        }
    }

});
function resetIndex() {
    selectedIndex.company_name = -1;
    selectedIndex.item_name = -1;
}
    // reset when typing new input
    $(document).on('input', '#company_name, #item_name', function () {
        resetIndex();
    });
    function setupAutocomplete(inputId, suggestionBoxId, url) {

    $(inputId).on('keyup', function (e) {

        // ignore arrow keys + enter
        if (e.keyCode == 38 || e.keyCode == 40 || e.keyCode == 13) {
            return;
        }

        let query = $(this).val();

        if (query.length < 1) {
            $(suggestionBoxId).html('');
            return;
        }

        $.ajax({
            url: url,
            method: "GET",
            data: { term: query },

            success: function (data) {
                let html = '';

                data.forEach(function (item) {
                    html += `<a href="#" class="list-group-item list-group-item-action">${item}</a>`;
                });

                $(suggestionBoxId).html(html);
            },

            error: function (err) {
                console.log(err);
            }
        });
    });

    // mouse click select
    $(document).on('click', suggestionBoxId + ' a', function (e) {
        e.preventDefault();
        $(inputId).val($(this).text());
        $(suggestionBoxId).html('');
        $(inputId).closest('form').submit();
    });
    // close on outside click
$(document).on('click', function (e) {
    if (!$(e.target).closest(inputId).length &&
        !$(e.target).closest(suggestionBoxId).length) {
        $(suggestionBoxId).html('');
    }
});

// close on blur (slight delay so click still works)
$(inputId).on('blur', function () {
    setTimeout(() => {
        $(suggestionBoxId).html('');
    }, 150);
});
$(document).on('mousedown', suggestionBoxId + ' a', function (e) {
    e.preventDefault(); // prevents blur before click
});
}

    setupAutocomplete('#company_name', '#company_suggestions', "<?php echo e(url('/probox/search-company')); ?>");
    setupAutocomplete('#item_name', '#item_suggestions', "<?php echo e(url('/probox/search-item')); ?>");

});
</script>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('styles'); ?>

<style>
     .autocomplete-wrapper {
    position: relative;
    width: 100%;
}
    .suggestion-box {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;   /* ✅ THIS is the key fix */
    z-index: 9999;
    max-height: 250px;
    overflow-y: auto;
}
    #company_suggestions .list-group-item.active,
#item_suggestions .list-group-item.active {
    background-color: #cedbe8 !important;
    color: inherit !important;
    border-color: #b9cfe5 !important;
}
    .btn-icon {
        padding: 2px 5px;
        line-height: 1;
        font-size: 0.8rem;
        border-radius: 6px;
    }

    .btn-icon i {
        font-size: 14px;
        vertical-align: middle;
    }

    .btn-icon:hover {
        background-color: #f1f1f1;
    }

    th, td {
        vertical-align: middle !important;
    }

    .table th {
        white-space: nowrap;
    }

    .table td {
        white-space: nowrap;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/packaging_specs/index.blade.php ENDPATH**/ ?>