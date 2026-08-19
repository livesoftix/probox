@extends('layouts.app')

@section('content')

<style>
    .voucher-wrapper {
        max-width: 1450px;
        margin: 0 auto;
    }

    .voucher-card {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, .08);
        background: #fff;
    }

    .voucher-header {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        padding: 28px 32px;
    }

    .voucher-title {
        font-size: 25px;
        font-weight: 700;
        letter-spacing: .3px;
        margin: 0;
    }

    .voucher-subtitle {
        font-size: 13px;
        opacity: .75;
        margin-top: 4px;
    }

    .voucher-number {
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 10px;
        padding: 10px 16px;
        text-align: right;
    }

    .voucher-number small {
        display: block;
        font-size: 11px;
        opacity: .7;
        text-transform: uppercase;
        letter-spacing: .6px;
    }

    .voucher-number strong {
        font-size: 18px;
    }

    .info-section {
        padding: 24px 32px;
        border-bottom: 1px solid #eef1f5;
    }

    .info-card {
        height: 100%;
        background: #f8fafc;
        border: 1px solid #e8edf3;
        border-radius: 12px;
        padding: 15px 18px;
    }

    .info-label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    .section-heading {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
    }

    .section-heading i {
        margin-right: 7px;
        color: #3b82f6;
    }

    .voucher-table-wrapper {
        padding: 25px 32px;
    }

    .voucher-table {
        margin: 0;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .voucher-table thead th {
        background: #f1f5f9;
        color: #334155;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .35px;
        padding: 13px 10px;
        border-bottom: 2px solid #dbe2ea;
        white-space: nowrap;
    }

    .voucher-table tbody td {
        padding: 12px 10px;
        font-size: 13px;
        color: #334155;
        vertical-align: middle;
    }

    .voucher-table tbody tr:hover {
        background: #f8fafc;
    }

    .sr-badge {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 700;
    }

    .product-name {
        font-weight: 600;
        color: #1e293b;
    }

    .sub-text {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        margin-top: 2px;
    }

    .amount-cell {
        font-weight: 700;
        color: #0f172a;
    }

    .total-row td {
        background: #f8fafc;
        padding: 16px 10px !important;
        border-top: 2px solid #cbd5e1;
    }

    .grand-total-label {
        font-size: 14px;
        font-weight: 700;
        color: #334155;
        text-align: right;
    }

    .grand-total {
        font-size: 20px;
        font-weight: 800;
        color: #2563eb;
    }

    .delivery-section {
        padding: 0 32px 28px;
    }

    .delivery-card {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px 20px;
    }

    .delivery-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .delivery-icon {
        width: 38px;
        height: 38px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e0f2fe;
        color: #0284c7;
        font-size: 18px;
    }

    .delivery-label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
    }

    .delivery-value {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    .voucher-footer {
        padding: 20px 32px;
        background: #f8fafc;
        border-top: 1px solid #e5e7eb;
    }

    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .action-bar .btn {
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
    }

    @media(max-width: 768px) {
        .voucher-header,
        .info-section,
        .voucher-table-wrapper,
        .delivery-section,
        .voucher-footer {
            padding-left: 16px;
            padding-right: 16px;
        }

        .voucher-header .row > div {
            margin-bottom: 15px;
        }

        .action-bar {
            flex-direction: column;
            align-items: stretch;
        }
    }

    @media print {

        body {
            background: #fff !important;
        }

        .page-title-box,
        .no-print,
        .navbar-custom,
        .leftside-menu,
        .footer {
            display: none !important;
        }

        .content-page,
        .content {
            margin: 0 !important;
            padding: 0 !important;
        }

        .voucher-wrapper {
            max-width: 100%;
        }

        .voucher-card {
            box-shadow: none;
            border: 0;
        }

        .voucher-header {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        .voucher-table thead th {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }
    }
</style>


<div class="container-fluid">

    {{-- Page Header --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <div class="page-title-right no-print">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">Softix</a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">Delivery Challan</a>
                        </li>

                        <li class="breadcrumb-item active">
                            View
                        </li>
                    </ol>
                </div>

                <h4 class="page-title">
                    Delivery Challan
                </h4>

            </div>
        </div>
    </div>


    <div class="voucher-wrapper">

        <div class="voucher-card">

            {{-- ================= HEADER ================= --}}
            <div class="voucher-header">

                <div class="row align-items-center">

                    <div class="col-md-8">

                        <div class="d-flex align-items-center gap-3">

                            <div>
                                <h3 class="voucher-title">
                                    <i class="uil uil-file-alt me-1"></i>
                                    Delivery Challan
                                </h3>

                                <div class="voucher-subtitle">
                                    Goods Dispatch / Delivery Document
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="voucher-number">

                            <small>Voucher Number</small>

                            <strong>
                                {{ $voucher->first()->v_no }}
                            </strong>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= BASIC INFORMATION ================= --}}
            <div class="info-section">

                <div class="section-heading">
                    <i class="uil uil-info-circle"></i>
                    Voucher Information
                </div>

                <div class="row g-3">

                    <div class="col-lg-3 col-md-6">

                        <div class="info-card">

                            <div class="info-label">
                                Voucher Date
                            </div>

                            <div class="info-value">

                                @if($voucher->first()->date)
                                    {{ \Carbon\Carbon::parse($voucher->first()->date)->format('d M Y') }}
                                @else
                                    —
                                @endif

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-md-6">

                        <div class="info-card">

                            <div class="info-label">
                                Party / Account
                            </div>

                            <div class="info-value">

                                {{ $voucher->first()->accounts->title ?? '—' }}

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-md-6">

                        <div class="info-card">

                            <div class="info-label">
                                Prepared By
                            </div>

                            <div class="info-value">

                                {{ $voucher->first()->preparedby ?? '—' }}

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-md-6">

                        <div class="info-card">

                            <div class="info-label">
                                Total Entries
                            </div>

                            <div class="info-value">

                                {{ $voucher->count() }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= ITEMS ================= --}}
            <div class="voucher-table-wrapper">

                <div class="section-heading">

                    <i class="uil uil-list-ul"></i>

                    Delivery Details

                </div>


                <div class="table-responsive">

                    <table class="table voucher-table">

                        <thead>

                            <tr>

                                <th width="55">#</th>

                                <th>Date</th>

                                <th>Product</th>

                                <th>Item</th>

                                <th>CTN</th>

                                <th>Pack Qty</th>

                                <th>PO No.</th>

                                <th class="text-end">Rate</th>

                                <th class="text-end">Total</th>

                                <th class="text-end">Freight</th>

                            </tr>

                        </thead>


                        <tbody>

                            @php
                                $grandTotal = 0;
                                $grandFreight = 0;
                                $sr = 0;
                            @endphp


                            @foreach($voucher as $trndtl)

                                @php

                                    $detail = $trndtl->deliveryDetails;

                                    $total = (float) ($detail->total ?? 0);

                                    $freight = (float) ($detail->freight ?? 0);

                                    $grandTotal += $total;

                                    $grandFreight += $freight;

                                @endphp


                                <tr>

                                    <td>

                                        <span class="sr-badge">

                                            {{ ++$sr }}

                                        </span>

                                    </td>


                                    <td>

                                        @if($trndtl->date)

                                            {{ \Carbon\Carbon::parse($trndtl->date)->format('d-m-Y') }}

                                        @else

                                            —

                                        @endif

                                    </td>


                                    <td>

                                        <span class="product-name">

                                            {{ $detail->products->prod_name ?? '—' }}

                                        </span>

                                    </td>


                                    <td>

                                        {{ $detail->itemType->type_title ?? '—' }}

                                    </td>


                                    <td>

                                        {{ number_format($detail->box ?? 0) }}

                                    </td>


                                    <td>

                                        {{ number_format($detail->pack_qty ?? 0) }}

                                    </td>


                                    <td>

                                        {{ $detail->batch_no ?? '—' }}

                                    </td>


                                    <td class="text-end">

                                        {{ number_format($detail->rate ?? 0, 2) }}

                                    </td>


                                    <td class="text-end amount-cell">

                                        {{ number_format($total, 2) }}

                                    </td>


                                    <td class="text-end">

                                        {{ number_format($freight, 2) }}

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>


                        <tfoot>

                            <tr class="total-row">

                                <td colspan="8">

                                    <div class="grand-total-label">

                                        Grand Total

                                    </div>

                                </td>

                                <td class="text-end">

                                    <div class="grand-total">

                                        {{ number_format($grandTotal, 2) }}

                                    </div>

                                </td>

                                <td class="text-end">

                                    <strong>

                                        {{ number_format($grandFreight, 2) }}

                                    </strong>

                                </td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>


            {{-- ================= DELIVERY INFORMATION ================= --}}
            <div class="delivery-section">

                <div class="section-heading">

                    <i class="uil uil-truck"></i>

                    Delivery Information

                </div>


                <div class="delivery-card">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="delivery-item">

                                <div class="delivery-icon">

                                    <i class="uil uil-user"></i>

                                </div>

                                <div>

                                    <div class="delivery-label">

                                        Driver Name

                                    </div>

                                    <div class="delivery-value">

                                        {{ $voucher->first()->driver_name ?? '—' }}

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="delivery-item">

                                <div class="delivery-icon">

                                    <i class="uil uil-car"></i>

                                </div>

                                <div>

                                    <div class="delivery-label">

                                        Vehicle Number

                                    </div>

                                    <div class="delivery-value">

                                        {{ $voucher->first()->vehicle_number ?? '—' }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= FOOTER ================= --}}
            <div class="voucher-footer no-print">

                <div class="action-bar">

                    <a href="{{ url()->previous() }}"
                        class="btn btn-light border">

                        <i class="uil uil-arrow-left me-1"></i>

                        Back

                    </a>


                    <div class="d-flex gap-2">

                        <a href="{{ route('delivery_challan.edit', ['v_no' => $voucher->first()->v_no]) }}"
                            class="btn btn-warning">

                            <i class="uil uil-edit me-1"></i>

                            Edit Voucher

                        </a>


                        <button type="button"
                            onclick="window.print()"
                            class="btn btn-dark">

                            <i class="uil uil-print me-1"></i>

                            Print

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection