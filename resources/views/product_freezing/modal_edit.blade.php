@php
    $row = $row ?? $productFreezing;
@endphp
<div class="modal fade"
     id="editModal{{ $row->id }}"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content shadow-lg border-0 rounded-3">

            <form action="{{ route('product-freezing.update',$row->id) }}"
                  method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <!-- Header -->
                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title fw-bold">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Product Freezing Slip

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

                                Slip No

                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $row->slip_no }}"
                                   readonly>

                        </div>

                        <!-- Date -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-semibold">

                                Date

                            </label>

                            <input type="date"
                                   name="date"
                                   class="form-control"
                                   value="{{ $row->date }}"
                                   required>

                        </div>

                        <!-- Status -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-semibold">

                                Status

                            </label>

                            <select name="status"
                                    class="form-control">

                                <option value="Active"
                                    {{ $row->product->status=='active' ? 'selected':'' }}>

                                    Active

                                </option>

                                <option value="Inactive"
                                    {{ $row->product->status=='Inactive' ? 'selected':'' }}>

                                    Inactive

                                </option>

                            </select>

                        </div>

                        <!-- Product -->

                        <div class="col-md-12 mb-3">

                            <label class="form-label fw-semibold">

                                Product Name

                            </label>

                            <select name="product_id"
                                    id="edit_product{{ $row->id }}"
                                    class="form-control edit-select2"
                                    required>

                                @foreach($products as $product)

                                <option value="{{ $product->id }}"
                                    {{ $product->id==$row->product_id ? 'selected':'' }}>

                                    {{ $product->prod_name }}

                                </option>

                                @endforeach

                            </select>

                        </div>

                        <!-- Description -->

                        <div class="col-md-12 mb-3">

                            <label class="form-label fw-semibold">

                                Description

                            </label>

                            <textarea name="description"
                                      class="form-control"
                                      rows="4">{{ $row->description }}</textarea>

                        </div>
<!-- Freezing Image -->
<div class="col-md-12 mb-3">

    <label class="form-label fw-semibold">Freezing Image</label>

    <div id="freezingImageWrapper{{ $row->id }}"
         class="freezing-preview-box"
         style="{{ $row->image ? '' : 'display:none;' }}">

        <img id="freezingEditPreview{{ $row->id }}"
             src="{{ $row->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($row->image) : '' }}"
             alt="Freezing Image Preview">

        <button type="button"
                class="remove-freezing-image"
                data-id="{{ $row->id }}"
                title="Remove Image">
            &times;
        </button>

    </div>

    <input type="hidden"
           name="remove_image"
           id="removeFreezingImageFlag{{ $row->id }}"
           value="0">

    <input type="file"
           name="image"
           id="freezingEditImage{{ $row->id }}"
           class="form-control freezing-image-input mt-2"
           data-id="{{ $row->id }}"
           accept="image/jpeg,image/png,image/webp">

    <small class="text-muted">
        Choose a new image to replace the current image, or press × to remove it.
    </small>

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

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Prepared By

                            </label>

                            <input type="text"
                                   name="prepared_by"
                                   class="form-control"
                                   value="{{ $row->prepared_by }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Production By

                            </label>

                            <input type="text"
                                   name="production_by"
                                   class="form-control"
                                   value="{{ $row->production_by }}">

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

                        Update Slip

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<style>
.freezing-preview-box {
    position: relative;
    width: 320px;
    height: 230px;
    max-width: 100%;
    padding: 10px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.freezing-preview-box img {
    display: block;
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    border-radius: 5px;
}

.remove-freezing-image {
    position: absolute;
    top: 7px;
    right: 7px;
    width: 25px;
    height: 25px;
    padding: 0;
    background: #dc3545;
    color: #fff;
    border: 1px solid #fff;
    border-radius: 50%;
    font-size: 18px;
    line-height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 5;
    box-shadow: 0 1px 4px rgba(0,0,0,.2);
}

.remove-freezing-image:hover {
    background: #b02a37;
}
</style>
<script>
$(document).on('change', '.freezing-image-input', function () {

    let id = $(this).data('id');
    let file = this.files[0];

    if (!file) return;

    let reader = new FileReader();

    reader.onload = function (e) {

        let preview = document.getElementById('freezingEditPreview' + id);
        let wrapper = document.getElementById('freezingImageWrapper' + id);

        preview.src = e.target.result;

        wrapper.style.display = 'flex';

        $('#removeFreezingImageFlag' + id).val('0');
    };

    reader.readAsDataURL(file);
});

$(document).on('click', '.remove-freezing-image', function () {

    let id = $(this).data('id');

    $('#freezingEditImage' + id).val('');

    $('#freezingEditPreview' + id).attr('src', '');

    $('#freezingImageWrapper' + id).hide();

    $('#removeFreezingImageFlag' + id).val('1');

});
</script>
