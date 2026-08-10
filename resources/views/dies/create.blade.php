@extends('layouts.app')

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

    /* =========================================================
       PAGE
    ========================================================= */

    .die-form-page {
        min-height: calc(100vh - 70px);
        background: #f3f6fb;
        padding: 28px 0 50px;
    }

    .die-form-container {
        width: 100%;
        background: #fff;
        border-radius: 32px;
        padding: 40px 51px 50px;
        box-shadow: 0 18px 45px rgba(31, 51, 73, .08);
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .die-form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding-bottom: 25px;

        border-bottom: 2px solid #edf1f5;
    }

    .die-form-title-area {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .die-form-title-icon {
        width: 52px;
        height: 52px;

        border-radius: 15px;

        background: #e9f0ff;
        color: #2864e8;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 25px;
    }

    .die-form-title {
        margin: 0;

        color: #071b39;

        font-size: 32px;
        font-weight: 800;

        letter-spacing: -.7px;
    }

    .die-form-subtitle {
        margin: 5px 0 0;

        color: #8291a3;

        font-size: 13px;
    }


    /* =========================================================
       BACK BUTTON
    ========================================================= */

    .die-back-btn {
        height: 46px;

        padding: 0 20px;

        border: none;
        border-radius: 12px;

        display: inline-flex;
        align-items: center;
        gap: 9px;

        background: #edf1f5;
        color: #344b65;

        font-size: 13px;
        font-weight: 700;

        text-decoration: none;

        transition: .2s ease;
    }

    .die-back-btn:hover {
        background: #e2e8ef;
        color: #1c344f;
    }


    /* =========================================================
       FORM CARD
    ========================================================= */

    .die-form-card {
        max-width: 900px;

        margin: 35px auto 0;

        border: 1px solid #e2e8f0;
        border-radius: 22px;

        background: #fff;

        overflow: hidden;
    }

    .die-form-card-header {
        padding: 20px 25px;

        background: #f8fafc;

        border-bottom: 1px solid #e5ebf1;
    }

    .die-form-card-header h3 {
        margin: 0;

        color: #17314f;

        font-size: 17px;
        font-weight: 750;
    }

    .die-form-card-header p {
        margin: 4px 0 0;

        color: #8796a8;

        font-size: 12px;
    }

    .die-form-body {
        padding: 30px;
    }


    /* =========================================================
       FORM GRID
    ========================================================= */

    .die-fields-grid {
        display: grid;

        grid-template-columns: repeat(2, 1fr);

        gap: 22px;
    }

    .die-field {
        display: flex;
        flex-direction: column;

        gap: 8px;
    }

    .die-field.full {
        grid-column: 1 / -1;
    }

    .die-label {
        color: #344b66;

        font-size: 13px;
        font-weight: 700;
    }

    .die-required {
        color: #e32732;
    }


    /* =========================================================
       INPUTS
    ========================================================= */

    .die-input,
    .die-select {
        width: 100%;
        height: 48px;

        padding: 0 14px;

        border: 1px solid #d8e0e9;
        border-radius: 11px;

        background: #fff;

        color: #1d334e;

        font-size: 13px;

        outline: none;

        transition: .18s ease;
    }

    .die-input:focus,
    .die-select:focus {
        border-color: #2864e8;

        box-shadow:
            0 0 0 3px rgba(40, 100, 232, .09);
    }

    .die-input[readonly] {
        background: #f5f7fa;

        color: #63758b;

        cursor: not-allowed;
    }


    /* =========================================================
       PRODUCT SELECT
    ========================================================= */

    .die-product-select-wrapper {
        position: relative;
    }

    .die-product-select-wrapper i {
        position: absolute;

        left: 15px;
        top: 50%;

        transform: translateY(-50%);

        color: #2864e8;

        pointer-events: none;
    }

    .die-product-select-wrapper .die-select {
        padding-left: 43px;
    }


    /* =========================================================
       INFO BOX
    ========================================================= */

    .die-product-info {
        display: none;

        margin-top: 25px;

        padding: 20px;

        border: 1px solid #d9e6fb;
        border-radius: 15px;

        background: #f5f9ff;
    }

    .die-product-info.active {
        display: grid;

        grid-template-columns:
            2fr
            1fr
            1fr
            1fr;

        gap: 20px;
    }

    .die-info-item {
        min-width: 0;
    }

    .die-info-label {
        color: #8494a7;

        font-size: 10px;
        font-weight: 700;

        text-transform: uppercase;

        letter-spacing: .5px;
    }

    .die-info-value {
        margin-top: 5px;

        color: #173352;

        font-size: 14px;
        font-weight: 750;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }


    /* =========================================================
       FIELD HELP
    ========================================================= */

    .die-help {
        color: #91a0b0;

        font-size: 11px;
    }


    /* =========================================================
       FOOTER
    ========================================================= */

    .die-form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 11px;

        margin-top: 30px;
        padding-top: 22px;

        border-top: 1px solid #e8edf2;
    }

    .die-btn {
        height: 46px;

        padding: 0 22px;

        border: none;
        border-radius: 11px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 9px;

        font-size: 13px;
        font-weight: 700;

        cursor: pointer;

        text-decoration: none;

        transition: .2s ease;
    }

    .die-cancel-btn {
        background: #edf1f5;
        color: #43566d;
    }

    .die-cancel-btn:hover {
        background: #e1e7ed;
        color: #2d435d;
    }

    .die-save-btn {
        background: #2864e8;
        color: #fff;
    }

    .die-save-btn:hover {
        background: #1d55cc;

        box-shadow:
            0 7px 18px rgba(40, 100, 232, .20);
    }


    /* =========================================================
       ALERT
    ========================================================= */

    .die-alert {
        max-width: 900px;

        margin: 22px auto 0;

        padding: 13px 16px;

        border-radius: 11px;

        display: flex;
        align-items: flex-start;

        gap: 10px;

        font-size: 13px;
    }

    .die-alert-danger {
        background: #ffe7e8;
        color: #b51d25;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 800px) {

        .die-form-container {
            padding: 30px 25px 40px;
        }

        .die-form-header {
            align-items: flex-start;
            gap: 20px;
        }

        .die-form-title {
            font-size: 27px;
        }

        .die-fields-grid {
            grid-template-columns: 1fr;
        }

        .die-field.full {
            grid-column: auto;
        }

        .die-product-info.active {
            grid-template-columns: repeat(2, 1fr);
        }

    }


    @media (max-width: 550px) {

        .die-form-page {
            padding: 10px 0 30px;
        }

        .die-form-container {
            border-radius: 20px;

            padding: 22px 15px 30px;
        }

        .die-form-header {
            flex-direction: column;
        }

        .die-back-btn {
            width: 100%;
            justify-content: center;
        }

        .die-form-card {
            margin-top: 25px;

            border-radius: 17px;
        }

        .die-form-body {
            padding: 20px 17px;
        }

        .die-product-info.active {
            grid-template-columns: 1fr;
        }

        .die-form-footer {
            flex-direction: column-reverse;
        }

        .die-btn {
            width: 100%;
        }

    }

</style>


<div class="die-form-page">

    <div class="die-form-container">


        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="die-form-header">

            <div class="die-form-title-area">

                <div class="die-form-title-icon">

                    <i class="fa-solid fa-scissors"></i>

                </div>

                <div>

                    <h1 class="die-form-title">
                        Add New Die
                    </h1>

                    <p class="die-form-subtitle">
                        Create a die from an existing product registration
                    </p>

                </div>

            </div>


            <a href="{{ route('dies.index') }}"
               class="die-back-btn">

                <i class="fa-solid fa-arrow-left"></i>

                Back to Dielines

            </a>

        </div>



        {{-- =====================================================
             VALIDATION ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div class="die-alert die-alert-danger">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            </div>

        @endif



        {{-- =====================================================
             FORM CARD
        ====================================================== --}}

        <div class="die-form-card">


            <div class="die-form-card-header">

                <h3>
                    Die Information
                </h3>

                <p>
                    Select a product to automatically load its registered dimensions and UP.
                </p>

            </div>


            <div class="die-form-body">


                <form action="{{ route('dies.store') }}"
                      method="POST">

                    @csrf


                    <div class="die-fields-grid">


                        {{-- =================================================
                             PRODUCT
                        ================================================== --}}

                        <div class="die-field full">

                            <label for="product_id"
                                   class="die-label">

                                Product
                                <span class="die-required">*</span>

                            </label>


                            <div class="die-product-select-wrapper">

                                <i class="fa-solid fa-box"></i>


                                <select name="product_id"
                                        id="product_id"
                                        class="die-select"
                                        required>

                                    <option value="">
                                        Select Product
                                    </option>


                                    @foreach($products as $product)

                                        <option value="{{ $product->id }}"
                                                data-item-name="{{ $product->item_name }}"
                                                data-length="{{ $product->length }}"
                                                data-width="{{ $product->width }}"
                                                data-ups="{{ $product->no_of_ups }}"

                                            {{ old('product_id') == $product->id ? 'selected' : '' }}>

                                            {{ $product->item_name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <span class="die-help">

                                Product is selected from Product Registration.

                            </span>

                        </div>



                        {{-- =================================================
                             AUTO INFORMATION BOX
                        ================================================== --}}

                        <div class="die-field full">

                            <div class="die-product-info"
                                 id="productInfo">


                                <div class="die-info-item">

                                    <div class="die-info-label">
                                        Item Name
                                    </div>

                                    <div class="die-info-value"
                                         id="infoItemName">
                                        —
                                    </div>

                                </div>


                                <div class="die-info-item">

                                    <div class="die-info-label">
                                        Length
                                    </div>

                                    <div class="die-info-value"
                                         id="infoLength">
                                        —
                                    </div>

                                </div>


                                <div class="die-info-item">

                                    <div class="die-info-label">
                                        Width
                                    </div>

                                    <div class="die-info-value"
                                         id="infoWidth">
                                        —
                                    </div>

                                </div>


                                <div class="die-info-item">

                                    <div class="die-info-label">
                                        No. of Ups
                                    </div>

                                    <div class="die-info-value"
                                         id="infoUps">
                                        —
                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                             ITEM NAME
                        ================================================== --}}

                        <div class="die-field">

                            <label for="item_name"
                                   class="die-label">

                                Item Name

                            </label>

                            <input type="text"
                                   id="item_name"
                                   name="item_name"
                                   class="die-input"
                                   value="{{ old('item_name') }}"
                                   readonly>

                            <span class="die-help">

                                Automatically taken from Product Registration.

                            </span>

                        </div>



                        {{-- =================================================
                             LENGTH
                        ================================================== --}}

                        <div class="die-field">

                            <label for="length"
                                   class="die-label">

                                Length

                            </label>

                            <input type="text"
                                   id="length"
                                   name="length"
                                   class="die-input"
                                   value="{{ old('length') }}"
                                   readonly>

                            <span class="die-help">

                                Registered product length.

                            </span>

                        </div>



                        {{-- =================================================
                             WIDTH
                        ================================================== --}}

                        <div class="die-field">

                            <label for="width"
                                   class="die-label">

                                Width

                            </label>

                            <input type="text"
                                   id="width"
                                   name="width"
                                   class="die-input"
                                   value="{{ old('width') }}"
                                   readonly>

                            <span class="die-help">

                                Registered product width.

                            </span>

                        </div>



                        {{-- =================================================
                             NO OF UPS
                        ================================================== --}}

                        <div class="die-field">

                            <label for="no_of_ups"
                                   class="die-label">

                                No. of Ups

                            </label>

                            <input type="text"
                                   id="no_of_ups"
                                   name="no_of_ups"
                                   class="die-input"
                                   value="{{ old('no_of_ups') }}"
                                   readonly>

                            <span class="die-help">

                                Automatically taken from Product Registration.

                            </span>

                        </div>


                    </div>



                    {{-- =====================================================
                         FOOTER
                    ====================================================== --}}

                    <div class="die-form-footer">


                        <a href="{{ route('dies.index') }}"
                           class="die-btn die-cancel-btn">

                            <i class="fa-solid fa-xmark"></i>

                            Cancel

                        </a>


                        <button type="submit"
                                class="die-btn die-save-btn">

                            <i class="fa-solid fa-floppy-disk"></i>

                            Save Die

                        </button>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

    const productSelect =
        document.getElementById('product_id');

    const itemNameInput =
        document.getElementById('item_name');

    const lengthInput =
        document.getElementById('length');

    const widthInput =
        document.getElementById('width');

    const upsInput =
        document.getElementById('no_of_ups');


    const productInfo =
        document.getElementById('productInfo');


    const infoItemName =
        document.getElementById('infoItemName');

    const infoLength =
        document.getElementById('infoLength');

    const infoWidth =
        document.getElementById('infoWidth');

    const infoUps =
        document.getElementById('infoUps');



    /* =========================================================
       LOAD PRODUCT DATA
    ========================================================= */

    function loadProductData() {

        const selectedOption =
            productSelect.options[
                productSelect.selectedIndex
            ];


        if (!selectedOption ||
            !selectedOption.value) {

            itemNameInput.value = '';
            lengthInput.value = '';
            widthInput.value = '';
            upsInput.value = '';

            infoItemName.textContent = '—';
            infoLength.textContent = '—';
            infoWidth.textContent = '—';
            infoUps.textContent = '—';

            productInfo.classList.remove('active');

            return;
        }


        const itemName =
            selectedOption.dataset.itemName || '';

        const length =
            selectedOption.dataset.length || '';

        const width =
            selectedOption.dataset.width || '';

        const ups =
            selectedOption.dataset.ups || '';


        /* Fill form fields */

        itemNameInput.value =
            itemName;

        lengthInput.value =
            length;

        widthInput.value =
            width;

        upsInput.value =
            ups;


        /* Fill information box */

        infoItemName.textContent =
            itemName || '—';

        infoLength.textContent =
            length || '—';

        infoWidth.textContent =
            width || '—';

        infoUps.textContent =
            ups || '—';


        productInfo.classList.add('active');

    }



    productSelect.addEventListener(
        'change',
        loadProductData
    );



    /* =========================================================
       RESTORE OLD VALUE AFTER VALIDATION
    ========================================================= */

    if (productSelect.value) {

        loadProductData();

    }

});

</script>

@endsection