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

    <h2 class="mb-4">Edit Job Detail</h2>

    <form action="{{ route('packaging-specs.update', $packagingSpec->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Basic Info --}}
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control"
                    value="{{ old('date', ($packagingSpec->date instanceof \Illuminate\Support\Carbon) ? $packagingSpec->date->format('Y-m-d') : $packagingSpec->date) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" id="company_name" class="form-control"
                       value="{{ old('company_name', $packagingSpec->company_name) }}"
                        placeholder="Company Name">
                          <div id="company_suggestions" class="list-group position-absolute w-100"></div>
                       
            </div>
            <div class="col-md-4">
                <label class="form-label">Item Name</label>
                <input type="text" name="item_name" id="item_name" class="form-control"
                       value="{{ old('item_name', $packagingSpec->item_name) }}"
                         placeholder="Item Name">
                           <div id="item_suggestions" class="list-group position-absolute w-100"></div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Country</label>
                <input type="text" name="country" id="country" class="form-control"
                       value="{{ old('country', $packagingSpec->country) }}">
            </div>
        </div>

        {{-- UPS / Printing / Board Size Section --}}
        <div class="row mt-4">
            <div class="col-12">
                <label class="form-label">Printing / Board / UPS</label>
                <table class="table table-bordered align-middle" id="details_table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Manual Die Size</th>
                            <th>Auto Die Size</th>
                            <th>UPS</th>
                            <th style="width: 80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packagingSpec->details as $index => $detail)
                            <tr data-index="{{ $index }}">
                                <td class="row-index">{{ $index + 1 }}</td>
                                <input type="hidden" name="details[{{ $index }}][id]" value="{{ $detail->id }}">
                                <td><input type="text" name="details[{{ $index }}][printing_size]" class="form-control"
                                           value="{{ old("details.$index.printing_size", $detail->printing_size) }}" required></td>
                                <td><input type="text" name="details[{{ $index }}][board_size]" class="form-control"
                                           value="{{ old("details.$index.board_size", $detail->board_size) }}" required></td>
                                <td><input type="text" name="details[{{ $index }}][ups]" class="form-control"
                                           value="{{ old("details.$index.ups", $detail->ups) }}" required></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                            </tr>
                        @endforeach
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
                    @foreach(['mm','cm','inch'] as $u)
                        <option value="{{ $u }}" {{ old('unit', $packagingSpec->unit) == $u ? 'selected' : '' }}>{{ $u }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Length</label>
                <input type="text" name="length" class="form-control" value="{{ old('length', $packagingSpec->length) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Width</label>
                <input type="text" name="width" class="form-control" value="{{ old('width', $packagingSpec->width) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Height</label>
                <input type="text" name="height" class="form-control" value="{{ old('height', $packagingSpec->height) }}">
            </div>
        </div>

        <div class="row mt-3 g-3">
            <div class="col-md-4">
                <label class="form-label">Lamination Size</label>
                <input type="text" name="lam_size" class="form-control" value="{{ old('lam_size', $packagingSpec->lam_size) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Flute Size</label>
                <input type="text" name="flute_size" class="form-control" value="{{ old('flute_size', $packagingSpec->flute_size) }}">
            </div>
                <div class="col-md-4">
                <label class="form-label">UV Size</label>
                <input type="text" name="uv_size" class="form-control" value="{{ old('uv_size', $packagingSpec->uv_size) }}">
            </div>
        </div>

        {{-- Box Type --}}
        <div class="row mt-3">
            <div class="col-md-4">
                <label class="form-label">Box Type</label>
                @php
                    $types = ['Box board','Corrugated','Bleach Card','Craft Board','Craft paper','Art paper','VRG paper','other'];
                    $currentType = old('box_type', $packagingSpec->box_type);
                @endphp
                <select name="box_type" id="box_type_select" class="form-control" required>
                    <option value="">Select Box Type</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ $currentType == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>

                <div id="box_type_other_wrap" class="mt-2" style="{{ $currentType == 'other' ? '' : 'display:none;' }}">
                    <input type="text" name="box_type_other" id="box_type_other" class="form-control"
                           placeholder="Enter custom box type"
                           value="{{ old('box_type_other', $packagingSpec->box_type_other) }}">
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <label class="form-label">Die pattern</label>
                <select name="die_pattern" id="Die_pattern_select" class="form-control">
                    <option value="">Select Die Pattern</option>
                    <option value="Single rule die cut" {{ old('die_pattern', $packagingSpec->die_pattern) == 'Single rule die cut' ? 'selected' : '' }}>Single rule die cut</option>
                    <option value="Double rule die cut" {{ old('die_pattern', $packagingSpec->die_pattern) == 'Double rule die cut' ? 'selected' : '' }}>Double rule die cut</option>                    
                </select>

            </div>
        </div>

        {{-- Box Details --}}
        <h4 class="mt-4">Box Details</h4>
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Glue Flap</label>
                <input type="text" name="glue_flap" class="form-control" value="{{ old('glue_flap', $packagingSpec->glue_flap) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Folding Flap</label>
                <input type="text" name="holding_flap" class="form-control" value="{{ old('holding_flap', $packagingSpec->holding_flap) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Pendi</label>
                <input type="text" name="pendi" class="form-control" value="{{ old('pendi', $packagingSpec->pendi) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Die Grip</label>
                <input type="text" name="die_grip" class="form-control" value="{{ old('die_grip', $packagingSpec->die_grip) }}" required>
            </div>
        </div>

        {{-- Designing Color & Printing Side --}}
        <div class="row mt-3 g-3">
            <div class="col-md-6">
                <label class="form-label">Designing Color</label>
                <input type="text" name="designing_color" class="form-control"
                       value="{{ old('designing_color', $packagingSpec->designing_color) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Printing Side</label>
                <select name="printing_side" class="form-control">
                    <option value="">Select Printing Side</option>
                    <option value="Front print" {{ old('printing_side', $packagingSpec->printing_side) == 'Front print' ? 'selected' : '' }}>Front print</option>
                    <option value="Front back" {{ old('printing_side', $packagingSpec->printing_side) == 'Front back' ? 'selected' : '' }}>Front back</option>
                </select>
            </div>
        </div>

        {{-- Finishing Options --}}
       {{-- Finishing Options --}}
<h4 class="mt-4 mb-3">Finishing Options</h4>

<div class="finishing-wrapper">
    {{-- Lamination --}}
    <div class="finishing-col mb-3">
        <div class="col-label fw-bold mb-2">Lamination:</div>
        <div class="d-flex flex-wrap gap-3">
            <label class="form-check-label">
                <input type="hidden" name="shine_lamination" value="0">
                <input type="checkbox" name="shine_lamination" value="1" class="form-check-input me-1"
                    {{ old('shine_lamination', $packagingSpec->shine_lamination) ? 'checked' : '' }}>
                Shine
            </label>
            <label class="form-check-label">
                <input type="hidden" name="matte_lamination" value="0">
                <input type="checkbox" name="matte_lamination" value="1" class="form-check-input me-1"
                    {{ old('matte_lamination', $packagingSpec->matte_lamination) ? 'checked' : '' }}>
                Matte
            </label>
          
        </div>
    </div>

    {{-- UV --}}
    <div class="finishing-col mb-3">
        <div class="col-label fw-bold mb-2">UV:</div>
        <div class="d-flex flex-wrap gap-3">
            <label class="form-check-label">
                <input type="hidden" name="uv_plain" value="0">
                <input type="checkbox" name="uv_plain" value="1" class="form-check-input me-1"
                    {{ old('uv_plain', $packagingSpec->uv_plain) ? 'checked' : '' }}>
                Plain
            </label>
            <label class="form-check-label">
                <input type="hidden" name="uv_spot" value="0">
                <input type="checkbox" name="uv_spot" value="1" class="form-check-input me-1"
                    {{ old('uv_spot', $packagingSpec->uv_spot) ? 'checked' : '' }}>
                Spot
            </label>
            <label class="form-check-label">
                <input type="hidden" name="uv_drip" value="0">
                <input type="checkbox" name="uv_drip" value="1" class="form-check-input me-1"
                    {{ old('uv_drip', $packagingSpec->uv_drip) ? 'checked' : '' }}>
                Drip
            </label>
        </div>
    </div>

    {{-- Windows --}}
    <div class="finishing-col mb-3">
        <div class="col-label fw-bold mb-2">Windows:</div>
        <div class="d-flex flex-wrap gap-3">
            <label class="form-check-label">
                <input type="hidden" name="window_glass" value="0">
                <input type="checkbox" name="window_glass" value="1" class="form-check-input me-1"
                    {{ old('window_glass', $packagingSpec->window_glass) ? 'checked' : '' }}>
                Glass
            </label>
            <label class="form-check-label">
                <input type="hidden" name="window_lamination" value="0">
                <input type="checkbox" name="window_lamination" value="1" class="form-check-input me-1"
                    {{ old('window_lamination', $packagingSpec->window_lamination) ? 'checked' : '' }}>
                Lamination
            </label>
        </div>
    </div>

    {{-- Finishing --}}
    <div class="finishing-col mb-3">
        <div class="col-label fw-bold mb-2">Finishing:</div>
        <div class="d-flex flex-wrap gap-3">
            <label class="form-check-label">
                <input type="hidden" name="emboss" value="0">
                <input type="checkbox" name="emboss" value="1" class="form-check-input me-1"
                    {{ old('emboss', $packagingSpec->emboss) ? 'checked' : '' }}>
                Emboss
            </label>
            <label class="form-check-label">
                <input type="hidden" name="demboss" value="0">
                <input type="checkbox" name="demboss" value="1" class="form-check-input me-1"
                    {{ old('demboss', $packagingSpec->demboss) ? 'checked' : '' }}>
                Deboss
            </label>
            <label class="form-check-label">
                <input type="hidden" name="gold_finish" value="0">
                <input type="checkbox" name="gold_finish" value="1" class="form-check-input me-1"
                    {{ old('gold_finish', $packagingSpec->gold_finish) ? 'checked' : '' }}>
                Gold Finish
            </label>
            <label class="form-check-label">
                <input type="hidden" name="silver_finish" value="0">
                <input type="checkbox" name="silver_finish" value="1" class="form-check-input me-1"
                    {{ old('silver_finish', $packagingSpec->silver_finish) ? 'checked' : '' }}>
                Silver Finish
            </label>
              <label class="form-check-label">
                <input type="hidden" name="varnish" value="0">
                <input type="checkbox" name="varnish" value="1" class="form-check-input me-1"
                    {{ old('varnish', $packagingSpec->varnish) ? 'checked' : '' }}> Varnish
            </label>
        </div>
    </div>
</div>


        {{-- Image Upload --}}
        <div class="mt-4">
            <label class="form-label">Upload Image (optional)</label>
            <input type="file" name="image_path" class="form-control">
            @if($packagingSpec->image_path)
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$packagingSpec->image_path) }}" alt="Preview"
                         style="max-height: 120px; border-radius: 4px;">
                </div>
            @endif
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('packaging-specs.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {

    function setupAutocomplete(inputId, suggestionBoxId, url) {
        $(inputId).on('keyup', function () {
            let query = $(this).val();

            if (query.length < 1) {
                $(suggestionBoxId).html('');
                return;
            }

            $.ajax({
                url: url,
                method: "GET",
                data: { term: query },
                success: function (data) {
                    // console.log('DATA:', data); // debug

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

    setupAutocomplete('#company_name', '#company_suggestions', "{{ url('/probox/search-company') }}");
    setupAutocomplete('#item_name', '#item_suggestions', "{{ url('/probox/search-item') }}");

});
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('box_type_select');
    const otherWrap = document.getElementById('box_type_other_wrap');
    const otherInput = document.getElementById('box_type_other');

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

    let detailIndex = {{ $packagingSpec->details->count() }};
    const addBtn = document.getElementById('add_detail');
    const tableBody = document.querySelector('#details_table tbody');

    function updateRowNumbers() {
        document.querySelectorAll('#details_table tbody tr').forEach((tr, i) => {
            tr.querySelector('.row-index').textContent = i + 1;
        });
    }

    addBtn.addEventListener('click', function() {
        const row = document.createElement('tr');
        row.dataset.index = detailIndex;
        row.innerHTML = `
            <td class="row-index"></td>
            <td><input type="text" name="details[${detailIndex}][printing_size]" class="form-control" required></td>
            <td><input type="text" name="details[${detailIndex}][board_size]" class="form-control" required></td>
            <td><input type="text" name="details[${detailIndex}][ups]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
        `;
        tableBody.appendChild(row);
        updateRowNumbers();
        detailIndex++;
    });

    document.body.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            const rows = document.querySelectorAll('#details_table tbody tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                updateRowNumbers();
            } else {
                alert('At least one UPS detail is required.');
            }
        }
    });

    updateRowNumbers();
});
</script>
@endsection
