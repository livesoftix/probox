
<div class="modal fade"
     id="editModal{{ $productFreezing->id }}"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content shadow-lg border-0 rounded-3">

            <form action="{{ route('product-freezing.update',$productFreezing->id) }}"
                  method="POST">

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
                                   value="{{ $productFreezing->slip_no }}"
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
                                   value="{{ $productFreezing->date }}"
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
                                    {{ $productFreezing->product->status=='active' ? 'selected':'' }}>

                                    Active

                                </option>

                                <option value="Inactive"
                                    {{ $productFreezing->product->status=='Inactive' ? 'selected':'' }}>

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
                                    id="edit_product{{ $productFreezing->id }}"
                                    class="form-control edit-select2"
                                    required>

                                @foreach($products as $product)

                                <option value="{{ $product->id }}"
                                    {{ $product->id==$productFreezing->product_id ? 'selected':'' }}>

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
                                      rows="4">{{ $productFreezing->description }}</textarea>

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
                                   value="{{ $productFreezing->prepared_by }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Production By

                            </label>

                            <input type="text"
                                   name="production_by"
                                   class="form-control"
                                   value="{{ $productFreezing->production_by }}">

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

    $('.modal').on('shown.bs.modal', function () {

        $(this).find('.edit-select2').select2({

            dropdownParent: $(this),
            width: '100%'

        });

    });

});
</script>