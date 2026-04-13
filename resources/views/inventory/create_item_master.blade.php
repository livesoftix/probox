@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Form Elements</li>
                    </ol>
                </div>
                <h4 class="page-title">Register Item</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="header-title">Add Item</h2>

                    <div class="tab-content mt-2">
                        <div class="tab-pane show active" id="input-types-preview">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form action="{{ route('inventory.itemmaster') }}" method="POST">
                                        @csrf

                                        {{-- Item Title --}}
                                        <div class="mb-3">
                                            <label for="item_code" class="form-label">Item Title</label>
                                            <input type="text" id="item_code" class="form-control" name="item_code"
                                                value="{{ old('item_code') }}" placeholder="Item Title" required>
                                            @error('item_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Item Type --}}
                                        <div class="mb-3">
                                            <label for="type_id" class="form-label">Item Type</label>
                                            <select name="type_id" id="type_id" class="form-control select2" data-toggle="select2" required>
                                                <option value="">Select</option>
                                                @foreach ($itemtypes as $itemtype)
                                                    <option value="{{ $itemtype->id }}"
                                                        {{ old('type_id') == $itemtype->id ? 'selected' : '' }}>
                                                        {{ $itemtype->type_title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('type_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Purchase --}}
                                        <div class="mb-3">
                                            <label for="purchase" class="form-label">Purchase</label>
                                            <input type="number" id="purchase" class="form-control" name="purchase"
                                                value="{{ old('purchase') }}" placeholder="Purchase" step="any">
                                            @error('purchase')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Sale Rate --}}
                                        <div class="mb-3">
                                            <label for="sale_rate" class="form-label">Sale Rate</label>
                                            <input type="number" id="sale_rate" class="form-control" name="sale_rate"
                                                value="{{ old('sale_rate') }}" placeholder="Sale Rate" step="any" >
                                            @error('sale_rate')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="mb-4">
                                            <h5 class="mb-2">Select Weight Type</h5>
                                            <input type="hidden" id="weight_type" name="weight_type" value="Grammage">
                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="weight_type" id="unitGrammage" value="Grammage" checked>
                                                    <label class="form-check-label" for="unitGrammage">Grammage</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="weight_type" id="unitKG" value="KG">
                                                    <label class="form-check-label" for="unitKG">KG</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="weight_type" id="unitPound" value="Pound">
                                                    <label class="form-check-label" for="unitPound">Pound</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="weight_type" id="unitLitre" value="Litre">
                                                    <label class="form-check-label" for="unitLitre">Litre</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="weight_type" id="unitpiece" value="Piece">
                                                    <label class="form-check-label" for="unitPiece">Piece</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label id="gramageLabel" for="gramage" class="form-label">Grammage</label>
                                            <input type="number" id="gramage" class="form-control" 
                                                name="gramage" value="{{ old('gramage') }}" 
                                                placeholder="Grammage" step="any" required>
                                            @error('gramage')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- JS for updating label + hidden input --}}
                                        <script>
                                            document.querySelectorAll('input[name="weight_type"]').forEach(radio => {
                                                radio.addEventListener('change', function() {
                                                    document.getElementById('gramageLabel').textContent = this.value;
                                                    document.getElementById('gramage').placeholder = this.value;
                                                    document.getElementById('weight_type').value = this.value;
                                                });
                                            });
                                        </script>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div>
</div>
@endsection
