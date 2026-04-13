@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Edit Disposable Purchase Freight</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Freight for DSPN-{{ $v_no }}</h4>
            </div>
        </div>
    </div>

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="input-types-preview">
                            <div class="row">
                                <div class="col-12">
                                <form id="freightForm" action="{{ route('disposable_purchase.updateFreight', $v_no) }}" method="POST">
                                    @csrf
                                    <div class="col-6">
                                        <!-- Freight Type Dropdown -->
                                        <div class="mb-3">
                                            <label for="freight_type" class="form-label">Freight Type</label>
                                            <select name="freight_type" class="form-control select2" id="freight_type">
                                                <option value="">Select</option>
                                                <option value="Bilty" {{ (old('freight_type', $freight_type ?? '') == 'Bilty') ? 'selected' : '' }}>Bilty</option>
                                                <option value="Per Piece" {{ (old('freight_type', $freight_type ?? '') == 'Per Piece') ? 'selected' : '' }}>Per Piece</option>
                                            </select>
                                        </div>

                                        <!-- Quantity Field (Initially Hidden) -->
                                        <div class="mb-3" id="qtyField" style="display: none;">
                                            <label for="qty" class="form-label">Quantity</label>
                                            <input type="number" id="qty" class="form-control" name="qty" value="{{ $totalQty }}" readonly>
                                        </div>

                                        <!-- Freight Input Field (Initially Hidden) -->
                                        <div class="mb-3" id="freightField" style="display: none;">
                                            <label for="freight" class="form-label">Freight</label>
                                            <input type="number" id="freight" class="form-control" name="freight" value="{{ old('freight', $freight) }}" step="any">
                                        </div>

                                        <!-- Total Freight Field (Read-only, Initially Hidden) -->
                                        <div class="mb-3" id="totalFreightField" style="display: none;">
                                            <label for="total_freight" class="form-label">Total Freight</label>
                                            <input type="number" id="total_freight" class="form-control" name="total_freight" step="any" readonly>
                                        </div>

                                        <!-- Hidden Input to Store Total Freight for Submission -->
                                        <input type="hidden" id="total_freight_hidden" name="total_freight">

                                        <button type="submit" class="btn btn-primary">Update Freight</button>
                                        <a href="{{ route('disposable_purchase.reports') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="mt-3">
        <strong>Total Qty for Voucher:</strong> {{ $totalQty }}
    </div> --}}
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const qtyField = document.getElementById('qtyField');
        const freightField = document.getElementById('freightField');
        const totalFreightField = document.getElementById('totalFreightField');
        const qtyInput = document.getElementById('qty');
        const freightInput = document.getElementById('freight');
        const totalFreightInput = document.getElementById('total_freight');
        const totalFreightHiddenInput = document.getElementById('total_freight_hidden');
        const freightTypeSelect = document.getElementById('freight_type');

        // Function to toggle visibility of fields based on freight type
        function toggleFields() {
            const freightType = freightTypeSelect.value;

            if (freightType === "Bilty") {
                qtyField.style.display = 'none';
                freightField.style.display = 'block';
                totalFreightField.style.display = 'none';
            } else if (freightType === "Per Piece") {
                qtyField.style.display = 'block';
                freightField.style.display = 'block';
                totalFreightField.style.display = 'none';
            } else {
                qtyField.style.display = 'none';
                freightField.style.display = 'none';
                totalFreightField.style.display = 'none';
            }
        }

        // Function to calculate total freight based on freight type
        function calculateTotalFreight() {
            const qty = parseFloat(qtyInput.value) || 0;
            const freight = parseFloat(freightInput.value) || 0;
            const freightType = freightTypeSelect.value;

            let totalFreight;

            if (freightType === "Bilty") {
                totalFreight = freight;
            } else if (freightType === "Per Piece") {
                totalFreight = qty * freight;
            } else {
                totalFreight = 0;
            }

            totalFreightInput.value = totalFreight.toFixed(2);
            totalFreightHiddenInput.value = totalFreight.toFixed(2);
        }

        freightTypeSelect.addEventListener('change', function () {
            toggleFields();
            calculateTotalFreight();
        });

        freightInput.addEventListener('input', calculateTotalFreight);

        // Initialize fields and calculations on page load
        toggleFields();
        calculateTotalFreight();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const freightInput = document.getElementById('freight');
        const isAdmin = {{ auth()->user()->is_admin ?? 0 }};
        const freightValue = parseFloat(freightInput.value) || 0;

        function setFreightReadonly() {
            if (freightValue > 0 && isAdmin === 0) {
                freightInput.readOnly = true;
            } else {
                freightInput.readOnly = false;
            }
        }

        setFreightReadonly();
    });
</script>
@endsection
