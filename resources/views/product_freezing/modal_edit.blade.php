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
<!-- Image -->
<div class="col-md-12 mb-3">

    <label class="form-label fw-semibold">Freezing Image</label>

    <div id="freezingImageWrapper" class="mb-2"
         style="{{ $row->image ? '' : 'display:none;' }} position:relative; width:fit-content;">

        <img id="freezingEditPreview"
             src="{{ $row->image ? asset('storage/' . $row->image) : '' }}"
             style="max-height:250px; max-width:100%; border:1px solid #ddd; padding:5px; border-radius:8px;">

        <button type="button"
                id="removeFreezingImage"
                class="btn btn-danger btn-sm"
                style="position:absolute; top:5px; right:5px; border-radius:50%;"
                title="Remove image">
            <i class="bi bi-x-lg"></i>
        </button>

    </div>

    <input type="hidden" name="remove_image" id="removeFreezingImageFlag" value="0">

    <input type="file"
           name="image"
           id="freezingEditImage"
           class="form-control"
           accept="image/*">

    <small class="text-muted">
        Select a new image to replace the existing one, or click × to remove it.
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
<script>
 $(document).ready(function () {

    // Preview newly selected image
    $('#freezingEditImage').on('change', function () {

        let file = this.files[0];

        if (!file) return;

        let reader = new FileReader();

        reader.onload = function (e) {
            $('#freezingEditPreview').attr('src', e.target.result);
            $('#freezingImageWrapper').show();
            $('#removeFreezingImageFlag').val('0');
        };

        reader.readAsDataURL(file);
    });

    // Remove existing/selected image
    $('#removeFreezingImage').on('click', function () {

        $('#freezingEditImage').val('');
        $('#freezingEditPreview').attr('src', '');
        $('#freezingImageWrapper').hide();
        $('#removeFreezingImageFlag').val('1');

    });

});
</script>
