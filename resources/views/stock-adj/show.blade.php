@extends('layouts.app')

@section('title', 'Stock Adjustment Details')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        {{ session('success') }}
    </div>
@endif

<div class="container-fluid pt-25">

    {{-- HEADER --}}
    <div class="row mb-3">
        <div class="col-lg-12" style="position: relative;">
            <h4 class="txt-primary mb-0">
                Stock Adjustment — {{ $stock_adj->v_no }}
            </h4>

            <div style="position:absolute; top:0; right:15px; display:flex; gap:6px;">

                {{-- FIXED: use ID not v_no --}}
                <a href="{{ route('stock-adj.edit', $stock_adj->id) }}"
                   class="btn btn-warning btn-sm">
                    <i class="fa fa-edit"></i>
                </a>

                <form action="{{ route('stock-adj.destroy', $stock_adj->id) }}"
                      method="POST"
                      class="d-inline">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete voucher {{ $stock_adj->v_no }}?')">
                        <i class="fa fa-close"></i>
                    </button>
                </form>

                <a href="{{ route('stock-adj.index') }}"
                   class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i>
                </a>

            </div>
        </div>
    </div>

    {{-- MASTER INFO --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">

                <div class="panel-heading">
                    <h6 class="panel-title txt-primary">Voucher Details</h6>
                </div>

                <div class="panel-body">
                    <div class="row">

                        <div class="col-lg-4">
                            <label class="txt-danger">Voucher No</label>
                            <p>{{ $stock_adj->v_no }}</p>
                        </div>

                        <div class="col-lg-4">
                            <label class="txt-danger">Voucher Date</label>
                            <p>{{ \Carbon\Carbon::parse($stock_adj->v_date)->format('d-M-Y') }}</p>
                        </div>

                        <div class="col-lg-4">
                            <label class="txt-danger">Prepared By</label>
                            <p>{{ $stock_adj->preparedByUser->name ?? $stock_adj->prepared_by }}</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ITEMS --}}
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">

                <div class="panel-heading">
                    <h6 class="panel-title txt-dark">Items</h6>
                </div>

                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $grandTotal = 0;
                                    $totalQty = 0;
                                @endphp

                                @forelse($stock_adj->details as $i => $detail)

                                    @php
                                        $item = $detail->item;
                                        $lineTotal = $detail->qty * $detail->rate;
                                        $grandTotal += $lineTotal;
                                        $totalQty += $detail->qty;
                                    @endphp

                                    <tr>
                                        <td>{{ $i + 1 }}</td>

                                        <td>
                                            {{ $item->item_name ?? $item->item_code ?? ('Item #' . $detail->item_id) }}
                                        </td>

                                        <td class="text-end">
                                            {{ number_format($detail->qty, 2) }}
                                        </td>

                                        <td class="text-end">
                                            {{ number_format($detail->rate, 2) }}
                                        </td>

                                        <td class="text-end">
                                            {{ number_format($lineTotal, 2) }}
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No items found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- TOTALS --}}
                    <div class="row mt-4">

                        <div class="col-md-6">
                            <div style="border-left:4px solid #17a2b8;padding:15px;background:#fff;">
                                <div style="display:flex;justify-content:space-between;">
                                    <span>Total Quantity</span>
                                    <strong>{{ number_format($totalQty, 2) }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div style="border-left:4px solid #28a745;padding:15px;background:#fff;">
                                <div style="display:flex;justify-content:space-between;">
                                    <span>Grand Total</span>
                                    <strong>PKR {{ number_format($grandTotal, 2) }}</strong>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection