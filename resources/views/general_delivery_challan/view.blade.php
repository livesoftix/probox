@extends('layouts.app')

@section('content')

<style>
    .gdc-wrapper {
        max-width: 1100px;
        margin: 0 auto;
    }

    .gdc-card {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 35px rgba(15, 23, 42, 0.08);
        border: 1px solid #e9edf3;
    }

    /* Header */
    .gdc-header {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        padding: 28px 32px;
    }

    .gdc-title {
        font-size: 25px;
        font-weight: 700;
        margin: 0;
        letter-spacing: .2px;
    }

    .gdc-subtitle {
        margin-top: 5px;
        font-size: 13px;
        color: rgba(255,255,255,.72);
    }

    .gdc-number-box {
        background: rgba(255,255,255,.10);
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 12px;
        padding: 12px 18px;
        text-align: right;
        min-width: 180px;
    }

    .gdc-number-box .label {
        display: block;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: rgba(255,255,255,.65);
        margin-bottom: 4px;
    }

    .gdc-number-box .number {
        font-size: 19px;
        font-weight: 700;
    }

    /* Sections */
    .gdc-section {
        padding: 28px 32px;
    }

    .gdc-section + .gdc-section {
        border-top: 1px solid #edf0f4;
    }

    .section-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 18px;
    }

    .section-title i {
        color: #3b82f6;
        margin-right: 7px;
    }

    /* Info cards */
    .info-card {
        height: 100%;
        padding: 16px 18px;
        background: #f8fafc;
        border: 1px solid #e6ebf1;
        border-radius: 12px;
    }

    .info-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .65px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .info-value {
        color: #1e293b;
        font-size: 14px;
        font-weight: 600;
        min-height: 20px;
    }

    /* Main item card */
    .item-card {
        border: 1px solid #e3e8ef;
        border-radius: 14px;
        overflow: hidden;
    }

    .item-card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e3e8ef;
        padding: 15px 20px;
        font-size: 14px;
        font-weight: 700;
        color: #334155;
    }

    .item-card-body {
        padding: 20px;
    }

    .item-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 12px 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .item-row:last-child {
        border-bottom: 0;
    }

    .item-label {
        color: #64748b;
        font-size: 12px;
    }

    .item-value {
        color: #1e293b;
        font-size: 14px;
        font-weight: 600;
        text-align: right;
    }

    /* Amount summary */
    .summary-card {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 9px 0;
    }

    .summary-label {
        font-size: 13px;
        color: #64748b;
    }

    .summary-value {
        font-size: 14px;
        font-weight: 600;
        color: #334155;
    }

    .summary-total {
        margin-top: 10px;
        padding-top: 15px;
        border-top: 2px solid #dbe2ea;
    }

    .summary-total .summary-label {
        font-size: 14px;
        font-weight: 700;
        color: #334155;
    }

    .summary-total .summary-value {
        font-size: 22px;
        font-weight: 800;
        color: #2563eb;
    }

    /* Footer */
    .gdc-footer {
        background: #f8fafc;
        border-top: 1px solid #e5e7eb;
        padding: 20px 32px;
    }

    .gdc-footer .btn {
        border-radius: 9px;
        padding: 8px 16px;
        font-weight: 600;
    }

    @media(max-width: 768px) {
        .gdc-header,
        .gdc-section,
        .gdc-footer {
            padding-left: 16px;
            padding-right: 16px;
        }

        .gdc-number-box {
            margin-top: 20px;
            text-align: left;
        }

        .item-row {
            flex-direction: column;
            gap: 3px;
        }

        .item-value {
            text-align: left;
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

        .gdc-wrapper {
            max-width: 100%;
        }

        .gdc-card {
            box-shadow: none;
            border: 0;
        }

        .gdc-header {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }
    }
</style>


<div class="container-fluid">

    {{-- Page title --}}
    <div class="row">

        <div class="col-12">

            <div class="page-title-box">

                <div class="page-title-right no-print">

                    <ol class="breadcrumb m-0">

                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">
                                Softix
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">
                                General Delivery Challan
                            </a>
                        </li>

                        <li class="breadcrumb-item active">
                            View
                        </li>

                    </ol>

                </div>

                <h4 class="page-title">
                    General Delivery Challan
                </h4>

            </div>

        </div>

    </div>


    <div class="gdc-wrapper">

        <div class="gdc-card">


            {{-- ================= HEADER ================= --}}

            <div class="gdc-header">

                <div class="row align-items-center">

                    <div class="col-md-8">

                        <h2 class="gdc-title">

                            <i class="uil uil-file-alt me-1"></i>

                            General Delivery Challan

                        </h2>

                        <div class="gdc-subtitle">

                            General Goods Delivery Document

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="gdc-number-box">

                            <span class="label">
                                GDC Number
                            </span>

                            <span class="number">
                                {{ $deliveryChallan->gjs_no ?? '—' }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= BASIC INFORMATION ================= --}}

            <div class="gdc-section">

                <div class="section-title">

                    <i class="uil uil-info-circle"></i>

                    Voucher Information

                </div>


                <div class="row g-3">


                    {{-- Date --}}
                    <div class="col-lg-3 col-md-6">

                        <div class="info-card">

                            <div class="info-label">
                                Date
                            </div>

                            <div class="info-value">

                                @if($deliveryChallan->updated_at)

                                    {{ \Carbon\Carbon::parse($deliveryChallan->updated_at)->format('d M Y') }}

                                @else

                                    —

                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- Prepared By --}}
                    <div class="col-lg-3 col-md-6">

                        <div class="info-card">

                            <div class="info-label">
                                Prepared By
                            </div>

                            <div class="info-value">

                                {{ $deliveryChallan->prepared_by ?? '—' }}

                            </div>

                        </div>

                    </div>


                    {{-- Party --}}
                    <div class="col-lg-3 col-md-6">

                        <div class="info-card">

                            <div class="info-label">
                                Party Name
                            </div>

                            <div class="info-value">

                                {{ $deliveryChallan->party_name ?? '—' }}

                            </div>

                        </div>

                    </div>


                    {{-- Product Type --}}
                    <div class="col-lg-3 col-md-6">

                        <div class="info-card">

                            <div class="info-label">
                                Product Type
                            </div>

                            <div class="info-value">

                                {{ $deliveryChallan->product_type ?? '—' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= ITEM DETAILS ================= --}}

            <div class="gdc-section">

                <div class="section-title">

                    <i class="uil uil-box"></i>

                    Item Details

                </div>


                <div class="item-card">

                    <div class="item-card-header">

                        <i class="uil uil-package me-1"></i>

                        Delivery Item

                    </div>


                    <div class="item-card-body">

                        <div class="row g-4">


                            <div class="col-md-6">

                                <div class="item-row">

                                    <span class="item-label">
                                        Item Name
                                    </span>

                                    <span class="item-value">
                                        {{ $deliveryChallan->item_name ?? '—' }}
                                    </span>

                                </div>


                                <div class="item-row">

                                    <span class="item-label">
                                        Product Type
                                    </span>

                                    <span class="item-value">
                                        {{ $deliveryChallan->product_type ?? '—' }}
                                    </span>

                                </div>


                                <div class="item-row">

                                    <span class="item-label">
                                        Quantity
                                    </span>

                                    <span class="item-value">
                                        {{ number_format((float)($deliveryChallan->qty ?? 0), 2) }}
                                    </span>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="item-row">

                                    <span class="item-label">
                                        Rate
                                    </span>

                                    <span class="item-value">
                                        {{ number_format((float)($deliveryChallan->rate ?? 0), 2) }}
                                    </span>

                                </div>


                                <div class="item-row">

                                    <span class="item-label">
                                        Freight
                                    </span>

                                    <span class="item-value">
                                        {{ number_format((float)($deliveryChallan->freight ?? 0), 2) }}
                                    </span>

                                </div>


                                @php
                                    $qty = (float)($deliveryChallan->qty ?? 0);
                                    $rate = (float)($deliveryChallan->rate ?? 0);
                                    $freight = (float)($deliveryChallan->freight ?? 0);

                                    $subtotal = $qty * $rate;
                                    $grandTotal = $subtotal + $freight;
                                @endphp


                                <div class="item-row">

                                    <span class="item-label">
                                        Item Amount
                                    </span>

                                    <span class="item-value">
                                        {{ number_format($subtotal, 2) }}
                                    </span>

                                </div>

                            </div>


                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= SUMMARY ================= --}}

            <div class="gdc-section">

                <div class="row justify-content-end">

                    <div class="col-lg-5 col-md-7">

                        <div class="summary-card">

                            <div class="summary-row">

                                <span class="summary-label">
                                    Quantity
                                </span>

                                <span class="summary-value">
                                    {{ number_format($qty, 2) }}
                                </span>

                            </div>


                            <div class="summary-row">

                                <span class="summary-label">
                                    Rate
                                </span>

                                <span class="summary-value">
                                    {{ number_format($rate, 2) }}
                                </span>

                            </div>


                            <div class="summary-row">

                                <span class="summary-label">
                                    Item Amount
                                </span>

                                <span class="summary-value">
                                    {{ number_format($subtotal, 2) }}
                                </span>

                            </div>


                            <div class="summary-row">

                                <span class="summary-label">
                                    Freight
                                </span>

                                <span class="summary-value">
                                    {{ number_format($freight, 2) }}
                                </span>

                            </div>


                            <div class="summary-row summary-total">

                                <span class="summary-label">
                                    Grand Total
                                </span>

                                <span class="summary-value">
                                    {{ number_format($grandTotal, 2) }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= FOOTER ================= --}}

            <div class="gdc-footer no-print">

                <div class="d-flex justify-content-between align-items-center">

                    <a href="{{ url()->previous() }}"
                        class="btn btn-light border">

                        <i class="uil uil-arrow-left me-1"></i>

                        Back

                    </a>


                    <div class="d-flex gap-2">

                        <a href="{{ route('general_delivery_challan.edit', $deliveryChallan->id) }}"
                            class="btn btn-warning">

                            <i class="uil uil-edit me-1"></i>

                            Edit

                        </a>


                        <button type="button"
                            class="btn btn-dark"
                            onclick="window.print()">

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