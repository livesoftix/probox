

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

    /* Header */
    .quotation-header {
        display: flex;
        align-items: center;
        gap: 18px;
        padding-bottom: 25px;
        border-bottom: 1px solid #dce3eb;
        margin-bottom: 38px;
    }

    .quotation-back {
        color: #52657a;
        font-size: 26px;
        text-decoration: none;
        width: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quotation-back:hover {
        color: #0d1b35;
    }

    .quotation-title {
        margin: 0;
        color: #0d1b35;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.3px;
    }

    .quotation-title i {
        margin-right: 8px;
    }

    /* Labels */
    .quotation-label {
        display: block;
        color: #0d1b35;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .quotation-label .required {
        color: #e53935;
    }

    /* Inputs */
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

    /* Items section */
    .items-section {
        margin-top: 54px;
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

    .items-table-header {
        display: grid;
        grid-template-columns: 1.05fr 1.5fr .55fr .55fr .75fr 25px;
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

    .quotation-item-row {
        display: grid;
        grid-template-columns: 1.05fr 1.5fr .55fr .55fr .75fr 25px;
        gap: 14px;
        align-items: center;
        padding: 9px 8px;
        border-bottom: 1px solid #d6dfe9;
    }

    .item-input {
        width: 100%;
        height: 39px;
        border: none;
        border-radius: 8px;
        background: #ffffff;
        padding: 0 11px;
        color: #17263d;
        font-size: 16px;
        outline: none;
    }

    .item-input:focus {
        box-shadow: 0 0 0 2px rgba(43, 76, 112, .12);
    }

    .item-total {
        font-size: 16px;
        font-weight: 700;
        color: #0d1b35;
        white-space: nowrap;
        text-align: right;
    }

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

    /* Description */
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
    }

    .description-textarea::placeholder {
        color: #748399;
    }

    /* Footer */
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

    /* Responsive */
    @media (max-width: 900px) {

        .quotation-card {
            padding: 30px 25px;
        }

        .items-table-header,
        .quotation-item-row {
            grid-template-columns: 1fr 1.3fr .7fr .7fr .8fr 25px;
            gap: 8px;
        }
    }

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

        .quotation-title {
            font-size: 23px;
        }

        .items-section {
            padding: 15px;
            overflow-x: auto;
        }

        .items-table-header,
        .quotation-item-row {
            min-width: 800px;
        }

        .description-section {
            padding: 18px;
        }
    }
</style>


<div class="quotation-page">

    <div class="quotation-card">

        
        
        

        <div class="quotation-header">

            <a href="<?php echo e(route('quotations.index')); ?>"
               class="quotation-back"
               title="Back">

                <i class="fas fa-arrow-left"></i>

            </a>

            <h1 class="quotation-title">

                <i class="fas fa-pen text-dark"></i>

                New Quotation

            </h1>

        </div>


        <form action="<?php echo e(route('quotations.store')); ?>"
              method="POST"
              id="quotationForm">

            <?php echo csrf_field(); ?>


            
            
            

            <div class="row">

                
                <div class="col-md-6 mb-3">

                    <label class="quotation-label">

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

                    <label class="quotation-label">

                        Party / Client Name

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

                    Items & Rates

                </div>


                
                <div class="items-table-header">

                    <div>Item Name</div>

                    <div>Details</div>

                    <div>Rate (PKR)</div>

                    <!-- <div>Qty</div>

                    <div>Total</div> -->

                    <div></div>

                </div>


                
                <div id="quotationItems">

                    <div class="quotation-item-row">

                        
                        <div>

                            <input
                                type="text"
                                name="items[0][item_name]"
                                class="item-input"
                                placeholder="Item name"
                                required
                            >

                        </div>


                        
                        <div>

                            <input
                                type="text"
                                name="items[0][details]"
                                class="item-input"
                                placeholder="Details"
                            >

                        </div>


                        
                        <div>

                            <input
                                type="number"
                                name="items[0][rate]"
                                class="item-input item-rate"
                                placeholder="0"
                                min="0"
                                step="0.01"
                                value="0"
                                required
                            >

                        </div>


                        
                        <!-- <div>

                            <input
                                type="number"
                                name="items[0][qty]"
                                class="item-input item-qty"
                                placeholder="1"
                                min="1"
                                step="1"
                                value="1"
                                required
                            >

                        </div>
 -->

                        
                        <!-- <div class="item-total">

                            PKR <span class="row-total">0</span>

                        </div> -->


                        
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

                    Description / Payment Terms

                </div>

                <textarea
                    name="description"
                    class="description-textarea"
                    placeholder="e.g. Payment due within 15 days. Thank you for your business!"
                ><?php echo e(old('description')); ?></textarea>

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
    | Calculate Row Total
    |--------------------------------------------------------------------------
    */

    function calculateRowTotal(row) {

        const rateInput = row.querySelector('.item-rate');

        const qtyInput = row.querySelector('.item-qty');

        const totalElement = row.querySelector('.row-total');


        const rate = parseFloat(rateInput.value) || 0;

        const qty = parseFloat(qtyInput.value) || 0;

        const total = rate * qty;


        totalElement.textContent = total.toLocaleString(
            'en-PK',
            {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Bind Calculation
    |--------------------------------------------------------------------------
    */

    function bindRow(row) {

        const rate = row.querySelector('.item-rate');

        const qty = row.querySelector('.item-qty');


        rate.addEventListener('input', function () {

            calculateRowTotal(row);

        });


        qty.addEventListener('input', function () {

            calculateRowTotal(row);

        });


        calculateRowTotal(row);
    }


    /*
    |--------------------------------------------------------------------------
    | Existing Row
    |--------------------------------------------------------------------------
    */

    const firstRow =
        itemsContainer.querySelector('.quotation-item-row');

    bindRow(firstRow);


    /*
    |--------------------------------------------------------------------------
    | Add New Item
    |--------------------------------------------------------------------------
    */

    addItemButton.addEventListener('click', function () {
console.log("kxn");
        const row = document.createElement('div');

        row.className = 'quotation-item-row';


        row.innerHTML = `

            <div>

                <input
                    type="text"
                    name="items[${itemIndex}][item_name]"
                    class="item-input"
                    placeholder="Item name"
                    required
                >

            </div>


            <div>

                <input
                    type="text"
                    name="items[${itemIndex}][details]"
                    class="item-input"
                    placeholder="Details"
                >

            </div>


            <div>

                <input
                    type="number"
                    name="items[${itemIndex}][rate]"
                    class="item-input item-rate"
                    placeholder="0"
                    min="0"
                    step="0.01"
                    value="0"
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


        bindRow(row);


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


        // Keep at least one item row
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