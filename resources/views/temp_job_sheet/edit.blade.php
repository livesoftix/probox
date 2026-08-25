@extends('layouts.app')

@section('content')

<style>
.a4-sheet {
    width: 280mm;
    min-height: 297mm;
    margin: auto;
    background: #fff;
    padding: 12mm;
    box-shadow: 0 0 10px rgba(0,0,0,.15);
}

@media print {
    .a4-sheet {
        width: 210mm;
        min-height: 297mm;
        box-shadow: none;
        padding: 10mm;
    }
}
</style>

<div class="container-fluid">

    <div class="card">
        <div class="card-body">

            <div class="a4-sheet">

                <form action="{{ route('tempjob.update', $job->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- DATE --}}
                        <div class="col-md-4 mb-3">
                            <label>Date</label>
                            <input
                                type="date"
                                name="date"
                                class="form-control"
                                value="{{ old('date', $job->date ? \Carbon\Carbon::parse($job->date)->format('Y-m-d') : '') }}"
                            >
                        </div>


                        {{-- PREPARED BY --}}
                        <div class="col-md-4 mb-3">
                            <label>Prepared By</label>

                            <input
                                type="text"
                                class="form-control"
                                name="preparedby"
                                value="{{ old('preparedby', $job->preparedby ?? $loggedInUser->name) }}"
                                readonly
                            >
                        </div>


                        {{-- JOB NO --}}
                        <div class="col-md-4 mb-3">
                            <label>Job No</label>

                            <input
                                type="text"
                                name="job_no"
                                class="form-control"
                                value="{{ old('job_no', $job->v_no) }}"
                            >
                        </div>


                        {{-- JOB NAME --}}
                        <div class="col-md-12 mb-3">
                            <label>Job Name</label>

                            <select
                                name="job_id"
                                id="job_id"
                                class="form-control select2"
                            >
                                <option value="">Select Job</option>

                                @foreach($products as $product)

                                    <option
                                        value="{{ $product->id }}"
                                        {{ old('job_id', $job->job_id) == $product->id ? 'selected' : '' }}
                                    >
                                        {{ $product->prod_name }}
                                    </option>

                                @endforeach

                            </select>
                        </div>


                        {{-- PRINTING FOR --}}
                        <div class="col-md-6 mb-3">

                            <label>Printing For</label>

                            <select
                                name="printing_for"
                                id="printing_for"
                                class="form-control"
                            >
                                <option value="">Select</option>

                                <option
                                    value="Proofing"
                                    {{ old('printing_for', $job->printing_for) == 'Proofing' ? 'selected' : '' }}
                                >
                                    Proofing
                                </option>

                                <option
                                    value="Job Production"
                                    {{ old('printing_for', $job->printing_for) == 'Job Production' ? 'selected' : '' }}
                                >
                                    Job Production
                                </option>

                            </select>

                        </div>


                        {{-- SIZE --}}
                        <div class="col-md-6 mb-3">
                            <label>Size</label>

                            <input
                                type="text"
                                name="size"
                                class="form-control"
                                value="{{ old('size', $job->size) }}"
                            >
                        </div>


                        {{-- UPS --}}
                        <div class="col-md-6 mb-3">
                            <label>Ups</label>

                            <input
                                type="number"
                                name="ups"
                                id="ups"
                                class="form-control"
                                value="{{ old('ups', $job->ups) }}"
                            >
                        </div>


                        {{-- QTY --}}
                        <div class="col-md-6 mb-3">
                            <label>Qty Of Boxes</label>

                            <input
                                type="number"
                                name="qty"
                                id="qty_boxes"
                                class="form-control"
                                value="{{ old('qty', $job->qty) }}"
                            >
                        </div>


                        {{-- P.SIZE --}}
                        <div class="col-md-6 mb-3">
                            <label>P.Size</label>

                            <input
                                type="text"
                                name="p_size"
                                id="p_size"
                                class="form-control"
                                value="{{ old('p_size', $job->p_size) }}"
                            >
                        </div>


                        {{-- REAM --}}
                        <div class="col-md-6 mb-3" style="display:none">
                            <label>No Of Used Rims / Pkt</label>

                            <input
                                type="text"
                                name="ream_pkt"
                                class="form-control"
                                value="{{ old('ream_pkt', $job->ream_packet) }}"
                            >
                        </div>


                        {{-- BOXBOARD --}}
                        <div class="col-12">

                            <hr>

                            <h5>Boxboard Details</h5>

                        </div>


                        <div class="col-12">

                            <div id="boxboard-wrapper">

                                @if($job->boxboards->count() > 0)

                                    @foreach($job->boxboards as $box)

    @php
    $formatDimension = function ($value) {
        return ((float) $value == floor((float) $value))
            ? (int) $value
            : $value;
    };

@endphp

                                        <div class="row item-row mb-3">

                                            {{-- ITEM --}}
                                            <div class="col-md-5">

                                                <label>Item</label>

                                                <select
                                                    class="form-control item-selection"
                                                    name="box_item[]"
                                                >

                                                    <option value="">Select Item</option>

@foreach($boxboardData as $item)

    @php
        $itemId = (int) $item->item_id;
        $itemWidth = (float) $item->width;
        $itemLength = (float) $item->length;
        $itemGrammage = round((float) $item->grammage);

        $boxId = (int) $box->item_id;
        $boxWidth = (float) $box->width;
        $boxLength = (float) $box->length;
        $boxGrammage = round((float) $box->grammage);

        // Compare dimensions in either direction
        $sameDimensions =
            ($itemWidth == $boxWidth && $itemLength == $boxLength) ||
            ($itemWidth == $boxLength && $itemLength == $boxWidth);

        $isSelected =
            $itemId === $boxId &&
            $itemGrammage === $boxGrammage &&
            $sameDimensions;

        $itemValue =
            $itemId . '_' .
            $formatDimension($itemWidth) . '_' .
            $formatDimension($itemLength) . '_' .
            $itemGrammage;

        $boxValue =
            $boxId . '_' .
            $formatDimension($boxWidth) . '_' .
            $formatDimension($boxLength) . '_' .
            $boxGrammage;
    @endphp

    <option
        value="{{ $itemValue }}"
        data-stock="{{ $item->remain_qty }}"
        data-itemid="{{ $item->item_id }}"
        data-stockvalue="{{ $itemValue }}"
        data-boxvalue="{{ $boxValue }}"
        data-isselected="{{ $isSelected ? 'yes' : 'no' }}"
        @if($isSelected) selected @endif
    >
        {{ $item->item_code }}
        (L:{{ $item->length }} x W:{{ $item->width }})
    </option>

@endforeach

                                                </select>

                                                <input
                                                    type="hidden"
                                                    name="purchase_vno[]"
                                                    class="purchase-vno"
                                                    value="{{ $box->purchase_v_no }}"
                                                >

                                            </div>


                                            {{-- LENGTH --}}
                                            <div class="col-md-3">

                                                <label>Length</label>

                                                <input
                                                    type="text"
                                                    class="form-control box-length"
                                                    name="box_length[]"
                                                    value="{{ $box->length }}"
                                                    readonly
                                                >

                                            </div>


                                            {{-- WIDTH --}}
                                            <div class="col-md-3">

                                                <label>Width</label>

                                                <input
                                                    type="text"
                                                    class="form-control box-width"
                                                    name="box_width[]"
                                                    value="{{ $box->width }}"
                                                    readonly
                                                >

                                            </div>
  {{-- grammage --}}
                                            <div class="col-md-3">

                                                <label>Grammage</label>

                                                <input
                                                    type="text"
                                                    class="form-control box-grammage"
                                                    name="box_grammage[]"
                                                    value="{{ $box->grammage }}"
                                                    readonly
                                                >

                                            </div>

                                            {{-- STOCK --}}
                                            <div class="col-md-3">

                                                <label>T.Stock</label>

                                                <input
                                                    type="number"
                                                    class="form-control total-stock"
                                                    value=""
                                                    readonly
                                                >

                                            </div>


                                            {{-- QTY --}}
                                            <div class="col-md-3">

                                                <label>No Of Used Rims / Pkt</label>

                                                <input
                                                    type="number"
                                                    class="form-control box-stock"
                                                    name="box_qty[]"
                                                    value="{{ $box->qty }}"
                                                    step="any"
                                                >

                                            </div>


                                            {{-- AFTER CUTTING --}}
                                            <div class="col-md-3">

                                                <label>After Cutting</label>

                                                <select
                                                    name="after_cutting[]"
                                                    class="form-control select2 after-cutting"
                                                >

                                                    <option value="">Select</option>

                                                    @for($i = 1; $i <= 4; $i++)

                                                        <option
                                                            value="{{ $i }}"
                                                            {{ $box->after_cutting == $i ? 'selected' : '' }}
                                                        >
                                                            {{ $i }}
                                                        </option>

                                                    @endfor

                                                </select>

                                            </div>


                                            {{-- REMAINING --}}
                                            <div class="col-md-3">

                                                <label>Remaining Stock</label>

                                                <input
                                                    type="number"
                                                    class="form-control box-total-stock"
                                                    readonly
                                                >

                                            </div>


                                            {{-- ACTION --}}
                                            <div class="col-md-2 d-flex align-items-end gap-2 mt-2">

                                                <button
                                                    type="button"
                                                    class="btn btn-success add-row"
                                                >
                                                    +
                                                </button>

                                                <button
                                                    type="button"
                                                    class="btn btn-danger remove-row"
                                                >
                                                    ×
                                                </button>

                                            </div>

                                        </div>

                                    @endforeach

                                @else

                                    {{-- DEFAULT EMPTY ROW --}}
                                    <div class="row item-row mb-3">

                                        <div class="col-md-5">

                                            <label>Item</label>

                                            <select
                                                class="form-control item-selection"
                                                name="box_item[]"
                                            >

                                                <option value="">Select Item</option>

                                                @foreach($boxboardData as $item)

                                                    <option
                                                        value="{{ $item->item_id }}_{{ $item->width }}_{{ $item->length }}_{{ $item->grammage }}"
                                                        data-stock="{{ $item->remain_qty }}"
                                                        data-itemid="{{ $item->item_id }}" >
                                                        {{ $item->item_code }}
                                                        (L:{{ $item->length }} x W:{{ $item->width }})
                                                    </option>

                                                @endforeach

                                            </select>

                                            <input
                                                type="hidden"
                                                name="purchase_vno[]"
                                                class="purchase-vno"
                                            >

                                        </div>


                                        <div class="col-md-3">

                                            <label>Length</label>

                                            <input
                                                type="text"
                                                class="form-control box-length"
                                                name="box_length[]"
                                                readonly
                                            >

                                        </div>


                                        <div class="col-md-3">

                                            <label>Width</label>

                                            <input
                                                type="text"
                                                class="form-control box-width"
                                                name="box_width[]"
                                                readonly
                                            >

                                        </div>
  {{-- Grammage --}}
                                            <div class="col-md-3">

                                                <label>Grammage</label>

                                                <input
                                                    type="text"
                                                    class="form-control box-grammage"
                                                    name="box_grammage[]"
                                                    readonly
                                                >

                                            </div>

                                        <div class="col-md-3">

                                            <label>T.Stock</label>

                                            <input
                                                type="number"
                                                class="form-control total-stock"
                                                readonly
                                            >

                                        </div>


                                        <div class="col-md-3">

                                            <label>No Of Used Rims / Pkt</label>

                                            <input
                                                type="number"
                                                class="form-control box-stock"
                                                name="box_qty[]"
                                                step="any"
                                            >

                                        </div>


                                        <div class="col-md-3">

                                            <label>After Cutting</label>

                                            <select
                                                name="after_cutting[]"
                                                class="form-control select2 after-cutting"
                                            >

                                                <option value="">Select</option>

                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>

                                            </select>

                                        </div>


                                        <div class="col-md-3">

                                            <label>Remaining Stock</label>

                                            <input
                                                type="number"
                                                class="form-control box-total-stock"
                                                readonly
                                            >

                                        </div>


                                        <div class="col-md-2 d-flex align-items-end gap-2 mt-2">

                                            <button
                                                type="button"
                                                class="btn btn-success add-row"
                                            >
                                                +
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-danger remove-row"
                                            >
                                                ×
                                            </button>

                                        </div>

                                    </div>

                                @endif

                            </div>

                        </div>


                        {{-- PROCESS --}}
                        <div class="col-12">

                            <hr>

                            <h5>Process Details</h5>

                        </div>


                        {{-- LAMINATION --}}
                        <div class="col-md-12">

                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="lamination"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="lamination"
                                    name="lamination"
                                    value="1"
                                    {{ old('lamination', $job->lamination) == 1 ? 'checked' : '' }}
                                >

                                <label class="form-check-label">
                                    Lamination
                                </label>

                            </div>


                            <div
                                id="laminationFields"
                                style="{{ $job->lamination == 1 ? 'display:block;' : 'display:none;' }}"
                            >

                                <div class="row mt-3">

                                    <div class="col-md-4">

                                        <label>Size</label>

                                        <input
                                            type="number"
                                            class="form-control"
                                            id="lsize"
                                            name="lsize"
                                            step="any"
                                            value="{{ $job->lam_size }}"
                                        >

                                    </div>


                                    <div class="col-md-8">

                                        <label>Item Type</label>

                                        <select
                                            name="litem"
                                            id="litem"
                                            class="form-control select2"
                                        >

                                            <option value="">Select Item</option>

                                            @foreach($items as $item)

                                                <option
                                                    value="{{ $item->id }}"
                                                    {{ $job->lam_item == $item->id ? 'selected' : '' }}
                                                >
                                                    {{ $item->item_code }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                            </div>


                            {{-- UV --}}
                            <div class="form-check mt-3">

                                <input
                                    type="hidden"
                                    name="uv"
                                    value="0"
                                >

                                <input
                                    type="checkbox"
                                    name="uv"
                                    id="uv"
                                    value="1"
                                    {{ $job->uv == 1 ? 'checked' : '' }}
                                >

                                <label class="form-check-label">
                                    UV
                                </label>

                            </div>


                            <div
                                id="uvFields"
                                style="{{ $job->uv == 1 ? 'display:block' : 'display:none' }}"
                            >

                                <div class="row">

                                    <div class="col-md-2 mb-3">

                                        <div class="form-check">

                                            <input
                                                type="hidden"
                                                name="simple"
                                                value="0"
                                            >

                                            <input
                                                type="checkbox"
                                                name="simple"
                                                id="simple"
                                                value="1"
                                                {{ $job->simple == 1 ? 'checked' : '' }}
                                            >

                                            <label>Simple</label>

                                        </div>

                                    </div>


                                    <div class="col-md-2 mb-3">

                                        <div class="form-check">

                                            <input
                                                type="hidden"
                                                name="spot"
                                                value="0"
                                            >

                                            <input
                                                type="checkbox"
                                                name="spot"
                                                id="spot"
                                                value="1"
                                                {{ $job->spot == 1 ? 'checked' : '' }}
                                            >

                                            <label>Spot</label>

                                        </div>

                                    </div>


                                    <div class="col-md-2 mb-3">

                                        <div class="form-check">

                                            <input
                                                type="hidden"
                                                name="tripof"
                                                value="0"
                                            >

                                            <input
                                                type="checkbox"
                                                name="tripof"
                                                id="tripof"
                                                value="1"
                                                {{ $job->tripof == 1 ? 'checked' : '' }}
                                            >

                                            <label>Trip Of</label>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- CORRUGATION --}}
                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="corrugation"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="corrugation"
                                    name="corrugation"
                                    value="1"
                                    {{ $job->corrugation == 1 ? 'checked' : '' }}
                                >

                                <label class="form-check-label">
                                    Corrugation
                                </label>

                            </div>


                            <div
                                id="corrugationFields"
                                style="{{ $job->corrugation == 1 ? 'display:block;' : 'display:none;' }}"
                            >

                                <div class="row mt-3">

                                    <div class="col-md-4">

                                        <label>Size</label>

                                        <input
                                            type="number"
                                            class="form-control"
                                            id="csize"
                                            name="csize"
                                            step="any"
                                            value="{{ $job->curr_size }}"
                                        >

                                    </div>


                                    <div class="col-md-8">

                                        <label>Item Type</label>

                                        <select
                                            name="citem"
                                            id="citem"
                                            class="form-control select2"
                                        >

                                            <option value="">Select Item</option>

                                            @foreach($items as $item)

                                                @if($item->type_id == 2)

                                                    <option
                                                        value="{{ $item->id }}"
                                                        {{ $job->curr_item == $item->id ? 'selected' : '' }}
                                                    >
                                                        {{ $item->item_code }}
                                                    </option>

                                                @endif

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                            </div>


                            {{-- COLOR --}}
                            <div class="col-md-3 form-check mt-3">

                                <input
                                    type="hidden"
                                    name="noColor"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="noColor"
                                    name="noColor"
                                    value="1"
                                    {{ $job->color == 1 ? 'checked' : '' }}
                                >

                                <label
                                    class="form-check-label"
                                    for="noColor"
                                >
                                    Color
                                </label>

                            </div>


                            <div
                                id="noColorFields"
                                style="{{ $job->color == 1 ? 'display:block;' : 'display:none;' }}"
                            >

                                <div class="mb-3">

                                    <label
                                        for="color"
                                        class="form-label"
                                    >
                                        Design Colors
                                    </label>

                                    <input
                                        type="number"
                                        id="color"
                                        class="form-control"
                                        name="color"
                                        value="{{ $job->color_no }}"
                                    >

                                </div>

                            </div>


                            {{-- WINDOW --}}
                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="window"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="window"
                                    name="window"
                                    value="1"
                                    {{ $job->window == 1 ? 'checked' : '' }}
                                >

                                <label
                                    class="form-check-label"
                                    for="window"
                                >
                                    Window
                                </label>

                            </div>


                            <div
                                id="windowOptions"
                                style="{{ $job->window == 1 ? 'display:block;' : 'display:none;' }} margin-top:10px; margin-bottom:10px; margin-left:20px;"
                            >

                                <div class="form-check">

                                    <input
                                        type="hidden"
                                        name="glass_win"
                                        value="0"
                                    >

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="glass_win"
                                        name="glass_win"
                                        value="1"
                                        {{ $job->glass_win == 1 ? 'checked' : '' }}
                                    >

                                    <label
                                        class="form-check-label"
                                        for="glass_win"
                                    >
                                        Glass Window
                                    </label>

                                </div>


                                <div class="form-check">

                                    <input
                                        type="hidden"
                                        name="lam_win"
                                        value="0"
                                    >

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="lam_win"
                                        name="lam_win"
                                        value="1"
                                        {{ $job->lam_window == 1 ? 'checked' : '' }}
                                    >

                                    <label
                                        class="form-check-label"
                                        for="lam_win"
                                    >
                                        Lamination Window
                                    </label>

                                </div>

                            </div>


                            {{-- VARNISH --}}
                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="varnish"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="varnish"
                                    name="varnish"
                                    value="1"
                                    {{ $job->varnish == 1 ? 'checked' : '' }}
                                >

                                <label
                                    class="form-check-label"
                                    for="varnish"
                                >
                                    Varnish
                                </label>

                            </div>


                            {{-- EMBOSS --}}
                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="emboss"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="emboss"
                                    name="emboss"
                                    value="1"
                                    {{ $job->emboss == 1 ? 'checked' : '' }}
                                >

                                <label
                                    class="form-check-label"
                                    for="emboss"
                                >
                                    Embosse
                                </label>

                            </div>


                            <div
                                id="embossFields"
                                style="{{ $job->emboss == 1 ? 'display:block;' : 'display:none;' }}"
                            >

                                <!-- <div class="mb-3" >

                                    <label
                                        for="emboss_rate"
                                        class="form-label"
                                    >
                                        Embosse Rate
                                    </label>

                                    <input
                                        type="number"
                                        id="emboss_rate"
                                        class="form-control"
                                        name="emboss_rate"
                                        step="any"
                                        value="{{ $job->emboss_rate }}"
                                    >

                                </div> -->

                            </div>


                            {{-- BREAKING --}}
                            <div class="form-check">

                                <input
                                    type="hidden"
                                    name="breaking"
                                    value="0"
                                >

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="breaking"
                                    name="breaking"
                                    value="1"
                                    {{ $job->breaking == 1 ? 'checked' : '' }}
                                >

                                <label
                                    class="form-check-label"
                                    for="breaking"
                                >
                                    Breaking
                                </label>

                            </div>

                        </div>


                        {{-- NOTE --}}
                        <div class="col-md-12 mb-3">

                            <label>Note</label>

                            <textarea
                                name="note"
                                rows="3"
                                class="form-control"
                            >{{ old('note', $job->note) }}</textarea>

                        </div>


                        {{-- M DATE --}}
                        <div class="col-md-6 mb-3">

                            <label>M.Date</label>

                            <input
                                type="date"
                                name="m_date"
                                class="form-control"
                                value="{{ old('m_date', $job->m_date ? \Carbon\Carbon::parse($job->m_date)->format('Y-m-d') : '') }}"
                            >

                        </div>


                        {{-- E DATE --}}
                        <div class="col-md-6 mb-3">

                            <label>E.Date</label>

                            <input
                                type="date"
                                name="e_date"
                                class="form-control"
                                value="{{ old('e_date', $job->e_date ? \Carbon\Carbon::parse($job->e_date)->format('Y-m-d') : '') }}"
                            >

                        </div>


                        {{-- BUTTONS --}}
                        <div class="col-12">

                            <button
                                type="submit"
                                class="btn btn-success"
                            >
                                Update Job Sheet
                            </button>

                            <a
                                href="{{ route('tempjob.index') }}"
                                class="btn btn-secondary"
                            >
                                Cancel
                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>

$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | SELECT2
    |--------------------------------------------------------------------------
    */

    $('#job_id').select2({
        placeholder: 'Select Job',
        allowClear: true,
        width: '100%'
    });


    function initSelect2(scope) {

        scope.find('.item-selection').select2({
            width: '100%'
        });

        scope.find('.after-cutting').select2({
            width: '100%'
        });

    }


    initSelect2($(document));


    $('#litem').select2({
        width: '100%'
    });


    $('#citem').select2({
        width: '100%'
    });


    /*
    |--------------------------------------------------------------------------
    | BOXBOARD ADD ROW
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.add-row', function () {

        let newRow = $('.item-row:first').clone();

        /*
        |--------------------------------------------------------------------------
        | Remove Select2 generated HTML
        |--------------------------------------------------------------------------
        */

        newRow.find('.select2-container').remove();

        /*
        |--------------------------------------------------------------------------
        | Reset fields
        |--------------------------------------------------------------------------
        */

        newRow.find('select').val('');

        newRow.find('.purchase-vno').val('');

        newRow.find('.total-stock').val('');

        newRow.find('.box-total-stock').val('');

        newRow.find('.box-stock').val('');

        newRow.find('.box-length').val('');

        newRow.find('.box-width').val('');
        newRow.find('.box-grammage').val('');
        $('#boxboard-wrapper').append(newRow);


        /*
        |--------------------------------------------------------------------------
        | Reinitialize Select2
        |--------------------------------------------------------------------------
        */

        initSelect2(newRow);


        calculateBoxes();

    });


    /*
    |--------------------------------------------------------------------------
    | REMOVE ROW
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.remove-row', function () {

        if ($('.item-row').length > 1) {

            $(this)
                .closest('.item-row')
                .remove();

            calculateBoxes();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | CALCULATE BOXES
    |--------------------------------------------------------------------------
    */

    function calculateBoxes() {

        let ups = parseFloat($('#ups').val()) || 0;

        let grandTotal = 0;


        $('.item-row').each(function () {

            let afterCutting =
                parseFloat(
                    $(this)
                        .find('.after-cutting')
                        .val()
                ) || 0;


            let qty =
                parseFloat(
                    $(this)
                        .find('.box-stock')
                        .val()
                ) || 0;


            let sheets = qty * 100;


            grandTotal +=
                ups *
                sheets *
                afterCutting;

        });


        $('#qty_boxes').val(grandTotal);

    }


    /*
    |--------------------------------------------------------------------------
    | ITEM CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on('change', '.item-selection', function () {

        let row = $(this).closest('.item-row');

        let selected = $(this).find(':selected');

        let value = $(this).val();

        let parts = value ? value.split('_') : [];


        let stock =
            parseFloat(
                selected.data('stock')
            ) || 0;


        row.find('.total-stock').val(stock);


        /*
        |--------------------------------------------------------------------------
        | IMPORTANT:
        | Remaining stock = stock - used qty
        |--------------------------------------------------------------------------
        */

        let qty =
            parseFloat(
                row.find('.box-stock').val()
            ) || 0;


        row.find('.box-total-stock')
            .val(stock - qty);
console.log(parts);

        if (parts.length >= 3) {

            row.find('.box-length')
                .val(parts[2]);
            row.find('.box-grammage')
                .val(parts[3]);

            row.find('.box-width')
                .val(parts[1]);

        }

    });


    /*
    |--------------------------------------------------------------------------
    | QTY CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on('input', '.box-stock', function () {

        let row = $(this).closest('.item-row');

        let total =
            parseFloat(
                row.find('.total-stock').val()
            ) || 0;


        let qty =
            parseFloat(
                $(this).val()
            ) || 0;


        if (qty > total) {

            alert('Stock exceed!');

            $(this).val('');

            qty = 0;

        }


        row.find('.box-total-stock')
            .val(total - qty);


        calculateBoxes();

    });


    /*
    |--------------------------------------------------------------------------
    | UPS
    |--------------------------------------------------------------------------
    */

    $(document).on('input', '#ups', function () {

        calculateBoxes();

    });


    /*
    |--------------------------------------------------------------------------
    | AFTER CUTTING
    |--------------------------------------------------------------------------
    */

    $(document).on('change', '.after-cutting', function () {

        calculateBoxes();

    });


    /*
    |--------------------------------------------------------------------------
    | LAMINATION
    |--------------------------------------------------------------------------
    */

    $('#lamination').on('change', function () {

        if ($(this).is(':checked')) {

            $('#laminationFields').show();

        } else {

            $('#laminationFields').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | UV
    |--------------------------------------------------------------------------
    */

    $('#uv').on('change', function () {

        if ($(this).is(':checked')) {

            $('#uvFields').show();

        } else {

            $('#uvFields').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | CORRUGATION
    |--------------------------------------------------------------------------
    */

    $('#corrugation').on('change', function () {

        if ($(this).is(':checked')) {

            $('#corrugationFields').show();

        } else {

            $('#corrugationFields').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | COLOR
    |--------------------------------------------------------------------------
    */

    $('#noColor').on('change', function () {

        if ($(this).is(':checked')) {

            $('#noColorFields').show();

        } else {

            $('#noColorFields').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | WINDOW
    |--------------------------------------------------------------------------
    */

    $('#window').on('change', function () {

        if ($(this).is(':checked')) {

            $('#windowOptions').show();

        } else {

            $('#windowOptions').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | EMBOSS
    |--------------------------------------------------------------------------
    */

    $('#emboss').on('change', function () {

        if ($(this).is(':checked')) {

            $('#embossFields').show();

        } else {

            $('#embossFields').hide();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | INITIAL BOXBOARD STOCK
    |--------------------------------------------------------------------------
    */

    $('.item-selection').each(function () {

        let row = $(this).closest('.item-row');

        let selected = $(this).find(':selected');

        let stock =
            parseFloat(
                selected.data('stock')
            ) || 0;


        /*
        |--------------------------------------------------------------------------
        | Existing edit row:
        | current stock from boxboard_stock_qty
        |--------------------------------------------------------------------------
        */

        row.find('.total-stock').val(stock);


        let qty =
            parseFloat(
                row.find('.box-stock').val()
            ) || 0;


        /*
        |--------------------------------------------------------------------------
        | Don't show negative remaining stock
        |--------------------------------------------------------------------------
        */

        row.find('.box-total-stock')
            .val(stock - qty);

    });


    /*
    |--------------------------------------------------------------------------
    | INITIAL BOX CALCULATION
    |--------------------------------------------------------------------------
    */

    calculateBoxes();

});

</script>

@endsection