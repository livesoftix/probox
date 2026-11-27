<div class="modal fade" id="freezeModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content shadow-lg border-0 rounded-3">

            <form action="{{ route('product-freezing.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <!-- Header -->
                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title fw-bold">

                        <i class="bi bi-snow me-2"></i>

                        Product Freezing Slip

                    </h5>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- Body -->
                <div class="modal-body">

                    <div class="row">

                        <!-- Slip No -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-semibold">

                                Slip No <span class="text-danger">*</span>

                            </label>
@php
$slipNo = 'PF-' . str_pad((\App\Models\ProductFreezing::max('id') ?? 0) + 1, 5, '0', STR_PAD_LEFT);
@endphp
                            <input type="text"
                                   class="form-control"
                                   name="slip_no"
                                   value="{{ $slipNo }}"
                                   readonly>

                        </div>

                        <!-- Date -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-semibold">

                                Date <span class="text-danger">*</span>

                            </label>

                            <input type="date"
                                   name="date"
                                   class="form-control"
                                   value="{{ date('Y-m-d') }}"
                                   required>

                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-semibold">

                                Status

                            </label>

                            <input type="text"
                                   id="status"
                                   class="form-control"
                                   value="Inactive"
                                   readonly>

                        </div>

                        <!-- Product -->
<div class="col-md-12 mb-3">
    <label class="form-label fw-semibold">
        Product Name <span class="text-danger">*</span>
    </label>

    <select name="product_ids[]"
            id="product_ids"
            class="form-control modal-product"
            multiple
            required>

        @foreach($products as $product)
            <option value="{{ $product->id }}"
                    data-status="{{ strtolower($product->status) }}">
                {{ $product->prod_name }} ({{ ucfirst($product->status) }})
            </option>
        @endforeach
    </select>

    <small class="text-muted">You can select multiple products.</small>
</div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">

                            <label class="form-label fw-semibold">

                                Description

                            </label>

                            <textarea name="description"
                                      rows="4"
                                      class="form-control"
                                      placeholder="Enter detailed description..."></textarea>

                        </div>

                    </div>

                     <!-- Image Upload -->
<div class="col-md-12 mb-3">
    <label class="form-label fw-semibold">Upload Image</label>

    <input type="file"
           name="image"
           id="freezing_image"
           class="form-control"
           accept="image/*">

    <div class="mt-2">
        <img id="freezing_image_preview"
             src=""
             alt="Image Preview"
             style="display:none; max-width:250px; max-height:200px; border-radius:8px;">
    </div>
</div>

                    <!-- Authorization -->

                    <div class="mt-3">

                        <h6 class="text-primary fw-bold">

                            <i class="bi bi-person-check me-1"></i>

                            Authorization

                        </h6>

                        <hr>

                    </div>

                    <div class="row">

                        <!-- Prepared By -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Prepared By

                            </label>

                            <input type="text"
                                   name="prepared_by"
                                   class="form-control"
                                   placeholder="Full name">

                        </div>

                        <!-- Production By -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Production By

                            </label>

                            <input type="text"
                                   name="production_by"
                                   class="form-control"
                                   placeholder="Production manager or representative">

                        </div>

                    </div>

                </div>

                <!-- Footer -->

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        <i class="bi bi-x-lg me-1"></i>

                        Cancel

                    </button>

                    <button type="reset"
                            class="btn btn-light border">

                        <i class="bi bi-arrow-clockwise me-1"></i>

                        Reset

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-save me-1"></i>

                        Save Slip

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- Select2 -->
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function () {

    // Product filter dropdown
    $('.product-filter').select2({
        width: '100%',
        placeholder: 'All Products',
        allowClear: true
    });

    // Multiple products inside freezing modal
    $('#product_ids').select2({
        dropdownParent: $('#freezeModal'),
        width: '100%',
        placeholder: 'Select Products',
        closeOnSelect: false
    });

    // Update status based on selected products
    $('#product_ids').on('change', function () {

        let selectedOptions = $(this).find(':selected');
        let statuses = selectedOptions.map(function () {
            return $(this).data('status');
        }).get();

        if (statuses.length === 0) {
            $('#status').val('Inactive');
            return;
        }

        let allActive = statuses.every(status => status === 'active');

        if (allActive) {
            $('#status').val('Inactive');
        } else if (statuses.every(status => status === 'inactive')) {
            $('#status').val('Inactive');
        } else {
            $('#status').val('Mixed');
        }
    });

    // Image preview
    $('#freezing_image').on('change', function () {

        let file = this.files[0];

        if (!file) {
            $('#freezing_image_preview').hide().attr('src', '');
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            this.value = '';
            $('#freezing_image_preview').hide().attr('src', '');
            return;
        }

        let reader = new FileReader();

        reader.onload = function (e) {
            $('#freezing_image_preview')
                .attr('src', e.target.result)
                .show();
        };

        reader.readAsDataURL(file);
    });

});
</script>