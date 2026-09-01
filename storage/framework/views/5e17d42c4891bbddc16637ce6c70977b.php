

<?php $__env->startSection('content'); ?>

<style>

.quotation-page {
    background: #f1f4f8;
    min-height: calc(100vh - 70px);
    padding: 30px 15px;
}

.quotation-card {
    max-width: 1100px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 40px 42px;
    box-shadow: 0 8px 30px rgba(15, 31, 55, 0.08);
}

/* =========================================================
   HEADER
========================================================= */

.quotation-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0;
    border-bottom: 1px solid #dfe5ec;
}

.company-section {
    display: flex;
    align-items: center;
    gap: 15px;
}

.logo-wrapper {
    width: 60px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo-wrapper img {
    display: block;
    object-fit: contain;
}

.brand-info {
    display: flex;
    flex-direction: column;
}

.company-name {
    margin: 0;
    font-size: 26px;
    font-weight: 800;
    color: #000;
    line-height: 1.1;
}

.company-name span {
    color: #e9252b;
}

.premium-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f1f4f8;
    color: #526d89;
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .4px;
    margin-top: 6px;
    width: fit-content;
}

.premium-badge i {
    color: #dda42e;
}

.quotation-heading {
    text-align: right;
}

.quotation-label {
    display: block;
    color: #0d1b35;
    font-size: 28px;
    font-weight: 800;
    letter-spacing: 1px;
}

/* =========================================================
   FORM LABELS
========================================================= */

.form-label-custom {
    display: block;
    color: #0d1b35;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
}

.required {
    color: #e53935;
}

/* =========================================================
   INPUTS
========================================================= */

.quotation-input {
    width: 100%;
    height: 50px;
    border: 1px solid #d8e0e9;
    border-radius: 11px;
    background: #fbfcfe;
    padding: 0 18px;
    color: #17263d;
    font-size: 17px;
    outline: none;
    transition: all 0.2s ease;
}

.quotation-input:focus {
    border-color: #8da0b8;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(43, 76, 112, 0.07);
}

/* =========================================================
   ITEMS SECTION
========================================================= */

.items-section {
    margin-top: 40px;
    background: #f3f6fa;
    border-radius: 12px;
    padding: 24px;
}

.items-heading {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #0d1b35;
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 28px;
}

.items-heading i {
    font-size: 17px;
}

/* Table Header */

.items-table-header {
    display: grid;
    grid-template-columns: 1fr 2fr 40px;
    gap: 14px;
    padding: 0 8px 12px;
    border-bottom: 1px solid #d6dfe9;
}

.items-table-header div {
    color: #52657a;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .3px;
}

/* Item Row */

.quotation-item-row {
    display: grid;
    grid-template-columns: 1fr 2fr 40px;
    gap: 14px;
    align-items: center;
    padding: 9px 8px;
    border-bottom: 1px solid #d6dfe9;
}

/* Item Dropdown */

.item-input {
    width: 100%;
    height: 42px;
    border: none;
    border-radius: 8px;
    background: #ffffff;
    padding: 0 11px;
    color: #17263d;
    font-size: 15px;
    outline: none;
}

.item-input:focus {
    box-shadow: 0 0 0 2px rgba(43, 76, 112, .12);
}

/* Details */

.details-input {
    width: 100%;
    height: 42px;
    border: none;
    border-radius: 8px;
    background: #ffffff;
    padding: 0 11px;
    color: #17263d;
    font-size: 15px;
    outline: none;
}

.details-input:focus {
    box-shadow: 0 0 0 2px rgba(43, 76, 112, .12);
}

/* Remove */

.remove-item {
    border: none;
    background: transparent;
    color: #e7a5aa;
    font-size: 18px;
    cursor: pointer;
    padding: 0;
}

.remove-item:hover {
    color: #dc3545;
}

/* Add Item */

.add-item-btn {
    margin-top: 15px;
    border: 1px dashed #cfd9e5;
    background: transparent;
    border-radius: 10px;
    color: #52657a;
    padding: 8px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: all .2s ease;
}

.add-item-btn:hover {
    background: #ffffff;
    border-color: #9eafc3;
    color: #0d1b35;
}

/* =========================================================
   DESCRIPTION / NOTES
========================================================= */

.description-section {
    margin-top: 24px;
    background: #f7f9fb;
    border-left: 4px solid #d8a536;
    border-radius: 12px;
    padding: 20px 24px 24px;
}

.description-heading {
    display: flex;
    align-items: center;
    gap: 9px;
    color: #0d1b35;
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 10px;
}

.description-textarea {
    width: 100%;
    min-height: 95px;
    resize: vertical;
    border: none;
    background: transparent;
    outline: none;
    padding: 0 4px;
    color: #17263d;
    font-size: 15px;
    line-height: 1.6;
}

.description-textarea::placeholder {
    color: #748399;
}

/* =========================================================
   FOOTER
========================================================= */

.quotation-footer {
    margin-top: 34px;
    padding-top: 24px;
    border-top: 1px solid #dce3eb;
    display: flex;
    align-items: center;
    gap: 15px;
}

.save-btn {
    height: 48px;
    padding: 0 27px;
    border: none;
    border-radius: 11px;
    background: #0d1b35;
    color: #ffffff;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s ease;
}

.save-btn:hover {
    background: #172b4d;
    transform: translateY(-1px);
}

.cancel-btn {
    height: 48px;
    padding: 0 27px;
    border: 1px solid #d6dfe9;
    border-radius: 11px;
    background: #ffffff;
    color: #0d1b35;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.cancel-btn:hover {
    background: #f6f8fa;
    color: #0d1b35;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 700px) {

    .quotation-page {
        padding: 15px;
    }

    .quotation-card {
        padding: 25px 18px;
        border-radius: 15px;
    }

    .quotation-header {
        margin-bottom: 25px;
    }

    .quotation-label {
        font-size: 22px;
    }

    .company-name {
        font-size: 22px;
    }

    .items-section {
        padding: 15px;
        overflow-x: auto;
    }

    .items-table-header,
    .quotation-item-row {
        min-width: 650px;
    }

    .description-section {
        padding: 18px;
    }
}

</style>


<div class="quotation-page">

    <div class="quotation-card">

        
        
        

        <div class="quotation-header">

            
            <div class="company-section">

                <div class="logo-wrapper">

                    <img src="<?php echo e(asset('assets/images/prologo.jpg')); ?>"
                         alt="Logo"
                         width="60"
                         height="50">

                </div>

                <div class="brand-info">

                    <h2 class="company-name">
                        Pro-<span>Box</span> Packages
                    </h2>

                    <div class="premium-badge">

                        <i class="fas fa-box"></i>

                        Printing & Packaging Solution

                    </div>

                </div>

            </div>


            
            <div class="quotation-heading">

                <div class="quotation-label">
                    QUOTATION
                </div>

            </div>

        </div>


        
        
        

        <form action="<?php echo e(route('quotations.store')); ?>"
              method="POST"
              id="quotationForm">

            <?php echo csrf_field(); ?>


            
            
            

            <div class="row">

                
                <div class="col-md-6 mb-3">

                    <label class="form-label-custom">

                        Date

                        <span class="required">*</span>

                    </label>

                    <input
                        type="date"
                        name="date"
                        class="quotation-input"
                        value="<?php echo e(old('date', date('Y-m-d'))); ?>"
                        required
                    >

                </div>


                
                <div class="col-md-6 mb-3">

                    <label class="form-label-custom">

                        To Client

                        <span class="required">*</span>

                    </label>

                    <input
                        type="text"
                        name="party_name"
                        class="quotation-input"
                        placeholder="e.g. ABC Traders"
                        value="<?php echo e(old('party_name')); ?>"
                        required
                    >

                </div>

            </div>


            
            
            

            <div class="items-section">

                <div class="items-heading">

                    <i class="fas fa-list-ul"></i>

                    Items & Details

                </div>


                
                <div class="items-table-header">

                    <div>
                        Item
                    </div>

                    <div>
                        Details
                    </div>

                    <div></div>

                </div>


                
                <div id="quotationItems">

                    
                    <div class="quotation-item-row">

                        
                        <div>

                            <select
                                name="items[0][item_name]"
                                class="item-input"
                                required
                            >

                                <option value="">
                                    Select Item
                                </option>

                                <option value="Product Name">
                                    Product Name
                                </option>

                                <option value="Minimum Order Quantity (MOQ)">
                                    Minimum Order Quantity (MOQ)
                                </option>

                                <option value="Product Detail">
                                    Product Detail
                                </option>

                                <option value="Product Rate">
                                    Product Rate
                                </option>

                            </select>

                        </div>


                        
                        <div>

                            <input
                                type="text"
                                name="items[0][details]"
                                class="details-input"
                                placeholder="Enter details"
                                required
                            >

                        </div>


                        
                        <div>

                            <button
                                type="button"
                                class="remove-item"
                                title="Remove Item"
                            >

                                <i class="fas fa-times"></i>

                            </button>

                        </div>

                    </div>

                </div>


                
                <button
                    type="button"
                    id="addItem"
                    class="add-item-btn"
                >

                    <i class="fas fa-plus-circle me-1"></i>

                    Add Item

                </button>

            </div>


            
            
            

            <div class="description-section">

                <div class="description-heading">

                    <i class="fas fa-file-alt"></i>

                    Notes

                </div>


                <textarea
                    name="description"
                    class="description-textarea"
                    placeholder="Enter quotation notes..."
                ><?php echo e(old('description', 'Thank you for choosing Pro-Box Packages. We look forward to serving you.')); ?></textarea>

            </div>


            
            
            

            <div class="quotation-footer">

                <button
                    type="submit"
                    class="save-btn"
                >

                    <i class="fas fa-save me-2"></i>

                    Save Quotation

                </button>


                <a
                    href="<?php echo e(route('quotations.index')); ?>"
                    class="cancel-btn"
                >

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>






<script>

document.addEventListener('DOMContentLoaded', function () {

    let itemIndex = 1;

    const itemsContainer = document.getElementById('quotationItems');
    const addItemButton = document.getElementById('addItem');


    /*
    |--------------------------------------------------------------------------
    | Add Item
    |--------------------------------------------------------------------------
    */

    addItemButton.addEventListener('click', function () {

        const row = document.createElement('div');

        row.className = 'quotation-item-row';


        row.innerHTML = `

            <div>

                <select
                    name="items[${itemIndex}][item_name]"
                    class="item-input"
                    required
                >

                    <option value="">
                        Select Item
                    </option>

                    <option value="Product Name">
                        Product Name
                    </option>

                    <option value="Minimum Order Quantity (MOQ)">
                        Minimum Order Quantity (MOQ)
                    </option>

                    <option value="Product Detail">
                        Product Detail
                    </option>

                    <option value="Product Rate">
                        Product Rate
                    </option>

                </select>

            </div>


            <div>

                <input
                    type="text"
                    name="items[${itemIndex}][details]"
                    class="details-input"
                    placeholder="Enter details"
                    required
                >

            </div>


            <div>

                <button
                    type="button"
                    class="remove-item"
                    title="Remove Item"
                >

                    <i class="fas fa-times"></i>

                </button>

            </div>

        `;


        itemsContainer.appendChild(row);

        itemIndex++;

    });


    /*
    |--------------------------------------------------------------------------
    | Remove Item
    |--------------------------------------------------------------------------
    */

    itemsContainer.addEventListener('click', function (event) {

        const removeButton =
            event.target.closest('.remove-item');


        if (!removeButton) {
            return;
        }


        const rows =
            itemsContainer.querySelectorAll('.quotation-item-row');


        /*
        |--------------------------------------------------------------------------
        | Keep at least one row
        |--------------------------------------------------------------------------
        */

        if (rows.length <= 1) {

            return;

        }


        removeButton
            .closest('.quotation-item-row')
            .remove();

    });


});

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\probox\resources\views/quotations/create.blade.php ENDPATH**/ ?>