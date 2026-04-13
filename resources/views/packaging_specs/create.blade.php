@extends('layouts.app')

@section('content')
<div class="container pt-4">

    {{-- Error & Success Messages --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2 class="mb-4">Create Job Detail</h2>

    <form action="{{ route('packaging-specs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Basic Info --}}
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Item Name</label>
                <input type="text" name="item_name" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control">
            </div>
        </div>

        {{-- UPS / Printing / Board Size Section --}}
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

        {{-- Main Packaging Specs --}}
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
                <input type="text" name="length" class="form-control" value="{{ old('length') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Width</label>
                <input type="text" name="width" class="form-control" value="{{ old('width') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Height</label>
                <input type="text" name="height" class="form-control" value="{{ old('height') }}">
            </div>
        </div>

        <div class="row mt-3 g-3">
            <div class="col-md-6">
                <label class="form-label">Lamination Size</label>
                <input type="text" name="lam_size" class="form-control" value="{{ old('lam_size') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Flute Size</label>
                <input type="text" name="flute_size" class="form-control" value="{{ old('flute_size') }}">
            </div>
        </div>

        {{-- Box Type --}}
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

        {{-- Box Details --}}
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

        {{-- Designing Color & Printing Side --}}
        <div class="row mt-3 g-3">
            <div class="col-md-6">
                <label class="form-label">Designing Color</label>
                <input type="text" name="designing_color" class="form-control" value="{{ old('designing_color') }}">
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

        {{-- Finishing Options --}}
        <h4 class="mt-4">Finishing Options</h4>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="form-check"><input type="checkbox" name="shine_lamination" value="1" class="form-check-input"> <label class="form-check-label">Shine Lamination</label></div>
                <div class="form-check"><input type="checkbox" name="matte_lamination" value="1" class="form-check-input"> <label class="form-check-label">Matte Lamination</label></div>
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

        {{-- Image Upload --}}
        <div class="mt-4">
            <label class="form-label">Upload Image (optional)</label>
            <input type="file" name="image_path" class="form-control">
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
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
@endsection
