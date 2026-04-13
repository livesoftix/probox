@extends('layouts.app')
@section('content')
<div class="container pt-4">
    <h1>Dashboard</h1>
    <p>Confectionary report</p>

    <!-- CDC vouchers without CBILLs section -->
    <div class="card mt-4">
        <div class="card-header bg-warning text-dark">
            <h5>CDC Vouchers Without CBILL</h5>
        </div>
        <div class="card-body">
            @php
                // Get all CDC voucher numbers and details
                $cdcVouchers = \App\Models\ConfectioneryMaster::with('accounts')->get();
                $cbillVnos = \App\Models\ConfectBilling::pluck('old_vno')->toArray();
                $cdcWithoutCbill = $cdcVouchers->filter(function($voucher) use ($cbillVnos) {
                    return !in_array($voucher->v_no, $cbillVnos);
                });
            @endphp
            <p><strong>Total CDC vouchers without CBILL:</strong> {{ $cdcWithoutCbill->count() }}</p>
            @if($cdcWithoutCbill->count())
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Voucher No</th>
                            <th>Date</th>
                            <th>Account</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       @php
    $shownVnos = [];
@endphp

@foreach($cdcWithoutCbill as $voucher)
    @if(!in_array($voucher->v_no, $shownVnos))
        @php
            $shownVnos[] = $voucher->v_no;
        @endphp
        <tr>
            <td>{{ $voucher->v_no }}</td>
            <td>{{ $voucher->date ? \Carbon\Carbon::parse($voucher->date)->format('d-m-Y') : '' }}</td>
            <td>{{ $voucher->accounts->title ?? 'N/A' }}</td>
        </tr>
    @endif
@endforeach

                    </tbody>
                </table>
            </div>
            @else
                <p class="text-success">All PBILL vouchers have CBILLs.</p>
            @endif
             @php
                // Get all CDC voucher numbers and details
                $cdcVouchers = \App\Models\DeliveryMaster::with('accounts')->get();
                $cbillVnos = \App\Models\SaleInvoice::pluck('old_vno')->toArray();
                $cdcWithoutCbill = $cdcVouchers->filter(function($voucher) use ($cbillVnos) {
                    return !in_array($voucher->v_no, $cbillVnos);
                });
            @endphp
            <p><strong>Total Pharmaceutical vouchers without PBILL:</strong> {{ $cdcWithoutCbill->count() }}</p>
            @if($cdcWithoutCbill->count())
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Voucher No</th>
                            <th>Date</th>
                            <th>Account</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       @php
    $shownVnos = [];
@endphp

@foreach($cdcWithoutCbill as $voucher)
    @if(!in_array($voucher->v_no, $shownVnos))
        @php
            $shownVnos[] = $voucher->v_no;
        @endphp
        <tr>
            <td>{{ $voucher->v_no }}</td>
            <td>{{ $voucher->date ? \Carbon\Carbon::parse($voucher->date)->format('d-m-Y') : '' }}</td>
            <td>{{ $voucher->accounts->title ?? 'N/A' }}</td>
        </tr>
    @endif
@endforeach

                    </tbody>
                </table>
            </div>
            @else
                <p class="text-success">All CDC vouchers have CBILLs.</p>
            @endif
        </div>
    </div>


@endsection
