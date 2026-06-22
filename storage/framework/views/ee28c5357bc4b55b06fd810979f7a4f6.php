<?php $__env->startSection('content'); ?>
<div class="container pt-4">

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <h2 class="mb-4">Create Job Detail</h2>

    <form action="<?php echo e(route('packaging-specs.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="<?php echo e(old('date', date('Y-m-d'))); ?>">
            </div>
            <div class="col-md-4 position-relative">
    <label class="form-label">Company Name</label>
     <div class="autocomplete-wrapper">

    <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name">

    <div id="company_suggestions" class="list-group suggestion-box"></div>
</div>
</div>
            <div class="col-md-4 position-relative">
                <label class="form-label">Item Name</label>
                 <div class="autocomplete-wrapper">
                <input type="text" name="item_name" id="item_name" class="form-control"  placeholder="Item Name">
                 <div id="item_suggestions"
                     class="list-group suggestion-box">
</div>
            </div>
</div>
            <div class="col-md-4">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control">
            </div>
        </div>

        
        <div class="row mt-4">
            <div class="col-12">
                <label class="form-label">Printing / Board / UPS </label>
                <table class="table table-bordered align-middle" id="details_table">
                    <thead class="table-light">
                        <tr>
                            <th>Manual Die Size</th>
                            <th>Auto Die Size</th>
                            <th>UPS</th>
                            <th style="width: 80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-index="0">
                            <td><input type="text" name="details[0][printing_size]" class="form-control" required></td>
                            <td><input type="text" name="details[0][board_size]" class="form-control" required></td>
                            <td><input type="text" name="details[0][ups]" class="form-control" required></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" id="add_detail" class="btn btn-secondary btn-sm">+ Add Row</button>
            </div>
        </div>

        
        <div class="row mt-4 g-3">
            <div class="col-md-2">
                <label class="form-label">Unit</label>
                <select name="unit" class="form-control" required>
                    <option value="">Select</option>
                    <option value="mm">mm</option>
                    <option value="cm">cm</option>
                    <option value="inch">inch</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Length</label>
                <input type="text" name="length" class="form-control" value="<?php echo e(old('length')); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Width</label>
                <input type="text" name="width" class="form-control" value="<?php echo e(old('width')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Height</label>
                <input type="text" name="height" class="form-control" value="<?php echo e(old('height')); ?>">
            </div>
        </div>

        <div class="row mt-3 g-3">
            <div class="col-md-4">
                <label class="form-label">Lamination Size</label>
                <input type="text" name="lam_size" class="form-control" value="<?php echo e(old('lam_size')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Flute Size</label>
                <input type="text" name="flute_size" class="form-control" value="<?php echo e(old('flute_size')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">UV Size</label>
                <input type="text" name="uv_size" class="form-control" value="<?php echo e(old('uv_size')); ?>">
            </div>
        </div>

        
        <div class="row mt-3">
            <div class="col-md-4">
                <label class="form-label">Box Type</label>
                <select name="box_type" id="box_type_select" class="form-control" required>
                    <option value="">Select Box Type</option>
                    <option value="Box board">Box Board</option>
                    <option value="Corrugated">Corrugated</option>
                    <option value="Bleach Card">Bleach Card</option>
                    <option value="Craft Board">Craft Board</option>
                    <option value="Craft paper">Craft paper</option>
                    <option value="Art paper">Art paper</option>
                    <option value="VRG paper">VRG paper</option>
                    <option value="other">Others</option>
                </select>

                <div id="box_type_other_wrap" class="mt-2" style="display:none;">
                    <input type="text" name="box_type_other" id="box_type_other" class="form-control" placeholder="Enter custom box type">
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <label class="form-label">Die pattern</label>
                <select name="die_pattern" id="Die_pattern_select" class="form-control">
                    <option value="">Select Die Pattern</option>
                    <option value="Single rule die cut">Single rule die cut</option>
                    <option value="Double rule die cut">Double rule die cut</option>                    
                </select>

            </div>
        </div>

        
        <h4 class="mt-4">Box Details</h4>
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Glue Flap</label>
                <input type="text" name="glue_flap" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Folding Flap</label>
                <input type="text" name="holding_flap" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Pendi</label>
                <input type="text" name="pendi" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Die Grip</label>
                <input type="text" name="die_grip" class="form-control" required>
            </div>
        </div>

        
        <div class="row mt-3 g-3">
            <div class="col-md-6">
                <label class="form-label">Designing Color</label>
                <input type="text" name="designing_color" class="form-control" value="<?php echo e(old('designing_color')); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Printing Side</label>
                <select name="printing_side" class="form-control">
                    <option value="">Select Printing Side</option>
                    <option value="Front print">Front print</option>
                    <option value="Front back">Front back</option>
                </select>
            </div>
        </div>

        
        <h4 class="mt-4">Finishing Options</h4>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="form-check"><input type="checkbox" name="shine_lamination" value="1" class="form-check-input"> <label class="form-check-label">Shine Lamination</label></div>
                <div class="form-check"><input type="checkbox" name="matte_lamination" value="1" class="form-check-input"> <label class="form-check-label">Matte Lamination</label></div>
               <div class="form-check"><input type="checkbox" name="varnish" value="1" class="form-check-input"> <label class="form-check-label">Varnish</label></div>

            </div>
            <div class="col-md-3">
                <div class="form-check"><input type="checkbox" name="uv_plain" value="1" class="form-check-input"> <label class="form-check-label">UV Plain</label></div>
                <div class="form-check"><input type="checkbox" name="uv_spot" value="1" class="form-check-input"> <label class="form-check-label">UV Spot</label></div>
                <div class="form-check"><input type="checkbox" name="uv_drip" value="1" class="form-check-input"> <label class="form-check-label">UV Drip</label></div>
            </div>
            <div class="col-md-3">
                <div class="form-check"><input type="checkbox" name="window_glass" value="1" class="form-check-input"> <label class="form-check-label">Glass Window</label></div>
                <div class="form-check"><input type="checkbox" name="window_lamination" value="1" class="form-check-input"> <label class="form-check-label">Lamination Window</label></div>
            </div>
            <div class="col-md-3">
                <div class="form-check"><input type="checkbox" name="emboss" value="1" class="form-check-input"> <label class="form-check-label">Emboss</label></div>
                <div class="form-check"><input type="checkbox" name="demboss" value="1" class="form-check-input"> <label class="form-check-label">Demboss</label></div>
                <div class="form-check"><input type="checkbox" name="gold_finish" value="1" class="form-check-input"> <label class="form-check-label">Gold finish</label></div>
                <div class="form-check"><input type="checkbox" name="silver_finish" value="1" class="form-check-input"> <label class="form-check-label">Silver finish</label></div>
            </div>
        </div>

        
        <div class="mt-4">
            <label class="form-label">Upload Image (optional)</label>
            <input type="file" name="image_path" class="form-control">
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // console.log('Create page scripts loaded'); // debug
    $(document).ready(function () {
// console.log('Document ready'); // debug 
    function setupAutocomplete(inputId, suggestionBoxId, url) {
        $(inputId).on('keyup', function (e) {
            // ignore arrows + enter so highlight stays
    if (e.keyCode == 38 || e.keyCode == 40 || e.keyCode == 13) {
        return;
    }
            let query = $(this).val();

            if (query.length < 1) {
                $(suggestionBoxId).html('');
                return;
            }

// console.log('Query:', query); // debug
            $.ajax({
                url: url,
                method: "GET",
                data: { term: query },
                success: function (data) {
                    // console.log('DATA:', data); // debug
                    // console.log('Query:', query); // debug

                    let html = '';
                    data.forEach(function (item) {
                        html += `<a href="#" class="list-group-item list-group-item-action">${item}</a>`;
                    });

                    $(suggestionBoxId).html(html);
                },
                error: function(err){
                    console.log('ERROR:', err);
                }
            });
        });

        $(document).on('click', suggestionBoxId + ' a', function (e) {
            e.preventDefault();
            $(inputId).val($(this).text());
            $(suggestionBoxId).html('');
            // $(inputId).closest('form').submit();
        });
    }
    // Add this inside your existing $(document).ready(function () { ... })

let selectedIndex = {
    company_name: -1,
    item_name: -1
};

function resetIndex() {
    selectedIndex.company_name = -1;
    selectedIndex.item_name = -1;
}

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
        let el = $(items[selectedIndex[inputId]]);

        el.addClass('active');

        // 🔥 AUTO SCROLL INTO VIEW
        el[0].scrollIntoView({
            block: "nearest",
            behavior: "smooth"
        });
    }
}

    // DOWN Arrow
    if (e.keyCode === 40) {
        e.preventDefault();
        if (items.length === 0) return;

        selectedIndex[inputId]++;

        if (selectedIndex[inputId] >= items.length) {
            selectedIndex[inputId] = 0;
        }

        highlightItem();
        return;
    }

    // UP Arrow
    if (e.keyCode === 38) {
        e.preventDefault();
        if (items.length === 0) return;

        selectedIndex[inputId]--;

        if (selectedIndex[inputId] < 0) {
            selectedIndex[inputId] = items.length - 1;
        }

        highlightItem();
        return;
    }

    // ENTER
    if (e.keyCode === 13) {
        if (selectedIndex[inputId] >= 0 && items.length > 0) {
            e.preventDefault();

            input.val($(items[selectedIndex[inputId]]).text());
            $(box).html('');
            selectedIndex[inputId] = -1;
        }
    }
});

// reset index when typing
$(document).on('input', '#company_name, #item_name', function () {
    resetIndex();
});
$(document).on('click', function (e) {
    if (!$(e.target).closest('.autocomplete-wrapper').length) {
        $('.suggestion-box').html('');
    }
});
$(document).on('blur', '#company_name, #item_name', function () {
    setTimeout(() => {
        $('.suggestion-box').html('');
    }, 150);
});

    setupAutocomplete('#company_name', '#company_suggestions', "<?php echo e(url('/probox/search-company')); ?>");
    setupAutocomplete('#item_name', '#item_suggestions', "<?php echo e(url('/probox/search-item')); ?>");

});
document.addEventListener('DOMContentLoaded', function() {
    // Handle "Other" box type field visibility
    const select = document.getElementById('box_type_select');
    const otherWrap = document.getElementById('box_type_other_wrap');
    const otherInput = document.getElementById('box_type_other');

    if (select) {
        select.addEventListener('change', function() {
            if (this.value === 'other') {
                otherWrap.style.display = 'block';
                otherInput.required = true;
            } else {
                otherWrap.style.display = 'none';
                otherInput.required = false;
                otherInput.value = '';
            }
        });
    }

    // Dynamic UPS row logic
    let detailIndex = 1;
    const addBtn = document.getElementById('add_detail');
    const tableBody = document.querySelector('#details_table tbody');

    addBtn.addEventListener('click', function() {
        const row = document.createElement('tr');
        row.dataset.index = detailIndex;
        row.innerHTML = `
            <td><input type="text" name="details[${detailIndex}][printing_size]" class="form-control" required></td>
            <td><input type="text" name="details[${detailIndex}][board_size]" class="form-control" required></td>
            <td><input type="text" name="details[${detailIndex}][ups]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
        `;
        tableBody.appendChild(row);
        detailIndex++;
    });

    // Handle removal of detail rows
    document.body.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });
});
</script>


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
    width: 100%;   /* 🔥 THIS fixes width mismatch */
    z-index: 9999;
    max-height: 250px;
    overflow-y: auto;
}
   .list-group-item.active {
     background-color: #cedbe8 !important;
    color: inherit !important;
    border-color: #b9cfe5 !important;
}

<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/packaging_specs/create.blade.php ENDPATH**/ ?>