@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f3f6fa;
    }

    .quotation-wrapper {
        max-width: 920px;
        margin: 30px auto;
    }

    .quotation-card {
        background: #fff;
        border-radius: 18px;
        padding: 40px;
        box-shadow: 0 8px 35px rgba(15, 30, 55, 0.08);
    }

    /* Top navigation */
    .quotation-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 25px;
        border-bottom: 1px solid #dfe5ec;
    }

    .back-link {
        color: #526d89;
        text-decoration: none;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 10px;
    }

    .back-link:hover {
        color: #0f1e37;
    }

    .quotation-title {
        margin: 0;
        font-size: 25px;
        font-weight: 700;
        color: #0f1e37;
    }

    .top-actions {
        display: flex;
        gap: 8px;
    }

    .btn-quotation {
        border: 1px solid #d7e0eb;
        background: #fff;
        color: #0f1e37;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .btn-quotation:hover {
        background: #f5f7fa;
        color: #0f1e37;
    }

    .btn-gold {
        background: #dda42e;
        border-color: #dda42e;
        color: #fff;
    }

    .btn-gold:hover {
        background: #c99225;
        border-color: #c99225;
        color: #fff;
    }

    /* Company Header */
    .company-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 23px 0 18px;
        border-bottom: 1px solid #dfe5ec;
    }

    .company-logo {
        width: 57px;
        height: 57px;
        border-radius: 15px;
        background: #0f1e37;
        color: #dda42e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        font-weight: 800;
        box-shadow: 0 5px 15px rgba(15, 30, 55, 0.18);
    }

    .company-name {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #0f1e37;
        line-height: 1.1;
    }

    .company-name span {
        color: #dda42e;
    }

    .premium-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f1f4f8;
        color: #526d89;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .4px;
        margin-top: 5px;
    }

    /* Information */
    .quotation-info {
        background: #f1f4f8;
        border-radius: 12px;
        padding: 18px 20px;
        margin-top: 20px;
        margin-bottom: 22px;
    }

    .info-item {
        margin-bottom: 13px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-label {
        display: block;
        color: #526d89;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 4px;
    }

    .info-value {
        color: #0f1e37;
        font-size: 16px;
        font-weight: 600;
    }

    .package-value {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .package-value i {
        color: #dda42e;
    }

    /* Items table */
    .quotation-table {
        width: 100%;
        border-collapse: collapse;
    }

    .quotation-table thead th {
        color: #526d89;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 600;
        padding: 10px 7px;
        border-bottom: 1px solid #d5dce5;
    }

    .quotation-table tbody td {
        padding: 13px 7px;
        color: #0f1e37;
        font-size: 14px;
        border-bottom: 1px solid #e0e5eb;
        vertical-align: middle;
    }

    .quotation-table tbody tr:last-child td {
        border-bottom: 2px solid #0f1e37;
    }

    .item-name {
        font-weight: 700;
    }

    .details-text {
        color: #526d89;
    }

    .amount {
        text-align: right;
        white-space: nowrap;
    }

    .grand-total-row td {
        border-bottom: 1px solid #dfe5ec !important;
        padding-top: 18px !important;
        padding-bottom: 18px !important;
    }

    .grand-total-label {
        text-align: right;
        font-size: 14px;
        font-weight: 700;
        color: #0f1e37;
    }

    .grand-total {
        text-align: right;
        color: #dda42e;
        font-size: 18px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* Description */
    .description-box {
        background: #f5f7f9;
        border-left: 4px solid #dda42e;
        border-radius: 11px;
        padding: 18px 22px;
        margin-top: 22px;
    }

    .description-title {
        color: #526d89;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .description-title i {
        color: #526d89;
        margin-right: 5px;
    }

    .description-content {
        color: #0f1e37;
        font-size: 14px;
        line-height: 1.7;
        white-space: pre-line;
    }

    /* Bottom actions */
    .bottom-actions {
        display: flex;
        gap: 10px;
        padding-top: 20px;
        margin-top: 28px;
        border-top: 1px solid #dfe5ec;
    }

    .btn-dark {
        background: #0f1e37;
        color: #fff;
        border: 1px solid #0f1e37;
        border-radius: 10px;
        padding: 9px 18px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .btn-dark:hover {
        background: #192a46;
        color: #fff;
    }

    .btn-danger-custom {
        background: #e9252b;
        color: #fff;
        border: 1px solid #e9252b;
        border-radius: 10px;
        padding: 9px 18px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .btn-danger-custom:hover {
        background: #cc1c22;
        color: #fff;
    }

    .btn-close-custom {
        background: #fff;
        color: #0f1e37;
        border: 1px solid #d7e0eb;
        border-radius: 10px;
        padding: 9px 18px;
        font-weight: 600;
        text-decoration: none;
    }

    /* Empty items */
    .empty-items {
        text-align: center;
        padding: 25px;
        color: #8a98a9;
    }

    /* Print */
    @media print {

        body {
            background: #fff !important;
        }

        .quotation-wrapper {
            margin: 0;
            max-width: 100%;
        }

        .quotation-card {
            box-shadow: none;
            padding: 20px;
        }

        .no-print {
            display: none !important;
        }

        .quotation-top {
            padding-bottom: 15px;
        }

        .company-header {
            padding-top: 15px;
        }
    }

    @media (max-width: 768px) {

        .quotation-wrapper {
            margin: 10px;
        }

        .quotation-card {
            padding: 20px;
        }

        .quotation-top {
            flex-direction: column;
            gap: 15px;
        }

        .top-actions {
            width: 100%;
        }

        .top-actions .btn-quotation {
            flex: 1;
            justify-content: center;
        }

        .quotation-table {
            min-width: 650px;
        }

        .table-wrapper {
            overflow-x: auto;
        }
    }
</style>


<div class="quotation-wrapper">

    <div class="quotation-card">

        {{-- ================= TOP ================= --}}
        <div class="quotation-top">

            <div>

                <a href="{{ route('quotations.index') }}" class="back-link no-print">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

                <h1 class="quotation-title">
                    Quotation
                </h1>

            </div>

            <div class="top-actions no-print">

                <button type="button"
                        class="btn-quotation"
                        onclick="window.print()">

                    <i class="fas fa-print"></i>
                    Print

                </button>

                <a href="{{ route('quotations.pdf', $quotation->id) }}"
   class="btn-quotation btn-gold">

    <i class="fas fa-file-pdf"></i>
    PDF

</a>
                <a href="{{ route('quotations.edit', $quotation->id) }}"
                   class="btn-quotation">

                    <i class="fas fa-edit"></i>
                    Edit

                </a>

            </div>

        </div>


        {{-- ================= COMPANY HEADER ================= --}}
        <div class="company-header">

            <div class="company-logo">
                PB
            </div>

            <div>

                <h2 class="company-name">
                    Pro-Box <span>Packages</span>
                </h2>

                <div class="premium-badge">
                    <i class="fas fa-box"></i>
                    PREMIUM QUOTATION
                </div>

            </div>

        </div>


        {{-- ================= QUOTATION INFO ================= --}}
        <div class="quotation-info">

            <div class="row">

                {{-- Date --}}
                <div class="col-md-6">

                    <div class="info-item">

                        <span class="info-label">
                            Date
                        </span>

                        <div class="info-value">

                            <i class="far fa-calendar-alt me-1"
                               style="color:#526d89;"></i>

                            {{ \Carbon\Carbon::parse($quotation->date)->format('d M Y') }}

                        </div>

                    </div>


                    {{-- Package --}}
                    <div class="info-item">

                        <span class="info-label">
                            Package
                        </span>

                        <div class="info-value package-value">

                            <i class="fas fa-box"></i>

                            Pro-Box Premium

                        </div>

                    </div>

                </div>


                {{-- Party --}}
                <div class="col-md-6">

                    <div class="info-item">

                        <span class="info-label">
                            Party / Client
                        </span>

                        <div class="info-value">

                            {{ $quotation->party->title ?? $quotation->party->name ?? 'N/A' }}

                        </div>

                    </div>


                    {{-- Reference --}}
                    <div class="info-item">

                        <span class="info-label">
                            Reference
                        </span>

                        <div class="info-value">

                            #PB-{{ str_pad($quotation->id, 4, '0', STR_PAD_LEFT) }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================= ITEMS ================= --}}
        <div class="table-wrapper">

            <table class="quotation-table">

                <thead>

                    <tr>

                        <th style="width:25%;">
                            Item
                        </th>

                        <th style="width:38%;">
                            Details
                        </th>

                        <th class="amount">
                            Rate
                        </th>

                        <th class="amount">
                            Qty
                        </th>

                        <th class="amount">
                            Total
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @php
                        $grandTotal = 0;
                    @endphp

                    @forelse($quotation->details as $item)

                        @php
                            $rate = (float) $item->rate;
                            $qty = (float) $item->qty;
                            $total = $rate * $qty;
                            $grandTotal += $total;
                        @endphp

                        <tr>

                            <td>
                                <div class="item-name">
                                    {{ $item->item_name }}
                                </div>
                            </td>

                            <td>
                                <div class="details-text">
                                    {{ $item->details ?: '-' }}
                                </div>
                            </td>

                            <td class="amount">
                                PKR {{ number_format($rate, 2) }}
                            </td>

                            <td class="amount">
                                {{ number_format($qty, 0) }}
                            </td>

                            <td class="amount">
                                PKR {{ number_format($total, 2) }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5">

                                <div class="empty-items">
                                    <i class="fas fa-box-open me-1"></i>
                                    No quotation items found.
                                </div>

                            </td>

                        </tr>

                    @endforelse


                    {{-- Grand Total --}}
                    <tr class="grand-total-row">

                        <td colspan="4"
                            class="grand-total-label">

                            Grand Total

                        </td>

                        <td class="grand-total">

                            PKR {{ number_format($grandTotal, 2) }}

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- ================= DESCRIPTION / TERMS ================= --}}
        @if(!empty($quotation->description))

            <div class="description-box">

                <div class="description-title">

                    <i class="fas fa-file-alt"></i>

                    Description / Terms

                </div>

                <div class="description-content">

                    {{ $quotation->description }}

                </div>

            </div>

        @endif


        {{-- ================= BOTTOM ACTIONS ================= --}}
        <div class="bottom-actions no-print">

            <a href="{{ route('quotations.edit', $quotation->id) }}"
               class="btn-dark">

                <i class="fas fa-edit"></i>
                Edit

            </a>


            <form action="{{ route('quotations.destroy', $quotation->id) }}"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this quotation?');"
                  style="display:inline;">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="btn-danger-custom">

                    <i class="fas fa-trash"></i>
                    Delete

                </button>

            </form>


            <a href="{{ route('quotations.index') }}"
               class="btn-close-custom">

                Close

            </a>

        </div>

    </div>

</div>

@endsection