@extends('layouts.app')

@section('content')
@php
    $row = $row ?? $row;
@endphp

<div class="container-fluid">

    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <div class="page-title-right">
                    <a href="{{ route('product-freezing.index') }}" class="btn btn-dark">
                        Back
                    </a>
                </div>

                <h4 class="page-title">
                    Edit Product Freezing
                </h4>

            </div>
        </div>
    </div>

    @if ($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <form action="{{ route('product-freezing.update',$row->id) }}"
                          method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="row">

                            <!-- Date -->

                            <div class="col-md-3 mb-3">

                                <label class="form-label">
                                    Date
                                </label>

                                <input
                                    type="date"
                                    name="date"
                                    class="form-control"
                                    value="{{ old('date',$row->date) }}"
                                    required>

                            </div>

                            <!-- Slip -->

                            <div class="col-md-3 mb-3">

                                <label class="form-label">
                                    Slip No
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $row->slip_no }}"
                                    readonly>

                            </div>

                            <!-- Product -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Product
                                </label>

                                <select
                                    name="product_id"
                                    class="form-control select2"
                                    required>

                                    @foreach($products as $product)

                                    <option
                                        value="{{ $product->id }}"
                                        {{ $product->id == $row->product_id ? 'selected':'' }}>

                                        {{ $product->prod_name }}

                                    </option>

                                    @endforeach

                                </select>

                            </div>

                            <!-- Status -->

                           <div class="col-md-3 mb-3">

    <label class="form-label">
        Status
    </label>

    <select name="status" class="form-control select2" data-toggle="select2">

        <option value="Active"
            {{ $row->product->status == 'active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="Inactive"
            {{ $row->product->status == 'inactive' ? 'selected' : '' }}>
            Inactive
        </option>

    </select>

</div>

                            <!-- Description -->

                            <div class="col-md-12 mb-3">

                                <label class="form-label">
                                    Description
                                </label>

                                <textarea
                                    name="description"
                                    rows="5"
                                    class="form-control">{{ old('description',$row->description) }}</textarea>

                            </div>
<!-- Image -->
<div class="col-md-12 mb-3">

    <label class="form-label fw-semibold">Freezing Image</label>

    @if($row->image)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $row->image) }}"
                 id="freezingEditPreview"
                 style="max-height:250px; max-width:100%; border:1px solid #ddd; padding:5px; border-radius:8px;">
        </div>
    @else
        <div class="mb-3">
            <img id="freezingEditPreview"
                 style="display:none; max-height:250px; max-width:100%; border:1px solid #ddd; padding:5px; border-radius:8px;">
        </div>
    @endif

    <input type="file"
           name="image"
           id="freezingEditImage"
           class="form-control"
           accept="image/*">

    <small class="text-muted">
        Leave empty to keep current image.
    </small>

</div>

                        </div>

                        <hr>

                        <button
                            class="btn btn-primary">

                            Update

                        </button>

                        <a
                            href="{{ route('product-freezing.index') }}"
                            class="btn btn-secondary">

                            Cancel

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
<script>
    $(document).on('change', '.edit-image-input', function () {
    let input = this;
    let previewId = $(this).data('preview');
    let preview = document.getElementById(previewId);

    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
});

$(document).on('change', '#freezingEditImage', function () {
    let input = this;
    let preview = document.getElementById('freezingEditPreview');

    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
});
</script>
@endsection