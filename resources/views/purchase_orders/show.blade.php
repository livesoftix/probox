@extends('layouts.app')

@section('content')

<style>

    body {
        background: #f3f6fa;
    }

    .quotation-wrapper {
        max-width: 1050px;
        margin: 30px auto;
    }

    .quotation-card {
        background: #fff;
        padding: 45px 50px;
        box-shadow: 0 8px 35px rgba(15, 30, 55, 0.08);
    }

    /* =========================================================
       TOP HEADER
    ========================================================= */

    .quotation-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 22px;
        border-bottom: 1px solid #ddd;
    }

    .company-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .company-logo {
        width: 65px;
        height: 65px;
        object-fit: contain;
    }

    .company-name {
        margin: 0;
        font-size: 25px;
        font-weight: 800;
        color: #000;
        line-height: 1.1;
    }

    .company-name span {
        color: #e9252b;
    }

    .company-tagline {
        margin-top: 5px;
        font-size: 14px;
        color: #526d89;
        font-weight: 600;
    }

    .quotation-heading {
        text-align: right;
    }

    .quotation-heading h1 {
        margin: 0;
        font-size: 34px;
        font-weight: 800;
        color: #000;
        letter-spacing: .5px;
    }

    .quotation-number {
        margin-top: 5px;
        font-size: 14px;
        color: #526d89;
    }

    /* =========================================================
       TOP ACTIONS
    ========================================================= */

    .top-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 18px;
    }

    .btn-quotation {
        border: 1px solid #d7e0eb;
        background: #fff;
        color: #0f1e37;
        border-radius: 9px;
        padding: 8px 16px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        cursor: pointer;
        transition: all 0.2s ease;
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

    /* =========================================================
       INFORMATION GRID
    ========================================================= */

    .quotation-info {
        margin-top: 25px;
        margin-bottom: 25px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px 30px;
    }

    .quotation-info-row {
        display: flex;
        align-items: flex-start;
        font-size: 16px;
        color: #000;
    }

    .quotation-info-label {
        font-weight: 700;
        min-width: 120px;
        color: #0d1b35;
    }

    .quotation-info-value {
        font-weight: 400;
        color: #17263d;
    }

    /* =========================================================
       ITEMS TABLE
    ========================================================= */

    .quotation-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .quotation-table th {
        background: #d3d3d3;
        color: #000;
        font-size: 16px;
        font-weight: 700;
        text-align: left;
        padding: 12px 16px;
        border: 1px solid #222;
    }

    .quotation-table td {
        color: #000;
        font-size: 16px;
        padding: 12px 16px;
        border: 1px solid #222;
        vertical-align: middle;
    }

    .quotation-table tfoot td,
    .quotation-table tfoot th {
        background: #f8f9fa;
        font-size: 16px;
        font-weight: 700;
        border: 1px solid #222;
        padding: 12px 16px;
    }

    /* =========================================================
       NOTES
    ========================================================= */

    .quotation-notes {
        margin-top: 32px;
        font-size: 16px;
        line-height: 1.7;
        color: #000;
    }

    .quotation-notes strong {
        font-weight: 700;
    }

    /* =========================================================
       BOTTOM ACTIONS
    ========================================================= */

    .bottom-actions {
        display: flex;
        gap: 10px;
        padding-top: 25px;
        margin-top: 30px;
        border-top: 1px solid #dfe5ec;
    }

    .btn-dark-custom {
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

    .btn-dark-custom:hover {
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
        cursor: pointer;
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

    .btn-close-custom:hover {
        background: #f5f7fa;
        color: #0f1e37;
    }

    /* =========================================================
       PRINT STYLES
    ========================================================= */

    @media print {
        @page {
            size: A4;
            margin: 15mm;
        }

        html, body {
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100%;
        }

        .quotation-wrapper {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .quotation-card {
            width: 100% !important;
            max-width: none !important;
            box-shadow: none !important;
            padding: 25px 30px !important;
            margin: 0 !important;
        }

        .no-print {
            display: none !important;
        }

        .quotation-header {
            display: flex !important;
            justify-content: space-between !important;
            border-bottom: 1px solid #ddd !important;
        }

        .company-left {
            display: flex !important;
            gap: 15px !important;
        }

        .company-logo {
            display: block !important;
            width: 65px !important;
            height: 65px !important;
        }

        .quotation-table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .quotation-table th {
            background: #d3d3d3 !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            border: 1px solid #222 !important;
        }

        .quotation-table td {
            border: 1px solid #222 !important;
            color: #000 !important;
        }
    }

    @media (max-width: 768px) {
        .quotation-wrapper {
            margin: 10px;
        }

        .quotation-card {
            padding: 25px;
        }

        .quotation-header {
            flex-direction: column;
            gap: 20px;
        }

        .quotation-heading {
            text-align: left;
        }

        .quotation-info {
            grid-template-columns: 1fr;
        }

        .table-wrapper {
            overflow-x: auto;
        }
    }

</style>

<div class="quotation-wrapper">

    <div class="quotation-card">

        {{-- HEADER --}}
        <div class="quotation-header">
            <div class="company-left">
                <img src="{{ asset('assets/images/prologo.jpg') }}" alt="Pro-Box Packages" class="company-logo">
                <div>
                    <h2 class="company-name">
                        Pro-<span>Box</span> Packages
                    </h2>
                    <div class="company-tagline">
                        Printing & Packaging Solution
                    </div>
                </div>
            </div>

            <div class="quotation-heading">
                <h1>PURCHASE ORDER</h1>
                @if(!empty($purchaseOrder->po_code))
                    <div class="quotation-number">
                        PO Code: <strong>{{ $purchaseOrder->po_code }}</strong>
                    </div>
                @endif
            </div>
        </div>

        {{-- TOP ACTION BUTTONS --}}
        <div class="top-actions no-print">
            <a href="{{ route('purchase_orders.index') }}" class="btn-quotation">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <button type="button" class="btn-quotation" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>

            <a href="{{ route('purchase_orders.edit', $purchaseOrder) }}" class="btn-quotation btn-gold">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>

        {{-- PURCHASE ORDER INFO GRID --}}
        <div class="quotation-info">
            <div class="quotation-info-row">
                <span class="quotation-info-label">Party Name:</span>
                <span class="quotation-info-value">{{ $purchaseOrder->party_name ?? 'N/A' }}</span>
            </div>

            <div class="quotation-info-row">
                <span class="quotation-info-label">PO Date:</span>
                <span class="quotation-info-value">{{ optional($purchaseOrder->po_date)->format('d F Y') ?? '-' }}</span>
            </div>

            <div class="quotation-info-row">
                <span class="quotation-info-label">Address:</span>
                <span class="quotation-info-value">{{ $purchaseOrder->party_address ?: '-' }}</span>
            </div>

            <div class="quotation-info-row">
                <span class="quotation-info-label">Delivery Date:</span>
                <span class="quotation-info-value">{{ optional($purchaseOrder->delivery_date)->format('d F Y') ?? '-' }}</span>
            </div>

            <div class="quotation-info-row">
                <span class="quotation-info-label">Machine Size:</span>
                <span class="quotation-info-value">{{ $purchaseOrder->machine_size ?: '-' }}</span>
            </div>

            <div class="quotation-info-row">
                <span class="quotation-info-label">Assign To:</span>
                <span class="quotation-info-value">{{ $purchaseOrder->assign_to ?: '-' }}</span>
            </div>

            <div class="quotation-info-row">
                <span class="quotation-info-label">Prepared By:</span>
                <span class="quotation-info-value">{{ $purchaseOrder->preparedBy->name ?? '-' }}</span>
            </div>

            <div class="quotation-info-row">
                <span class="quotation-info-label">Print By:</span>
                <span class="quotation-info-value">{{ $purchaseOrder->print_by ?: '-' }}</span>
            </div>
        </div>

        {{-- ITEMS TABLE --}}
        <div class="table-wrapper">
            <table class="quotation-table">
                <thead>
                    <tr>
                        <th style="width: 70px; text-align: center;">#</th>
                        <th>Item Name</th>
                        <th style="width: 200px; text-align: right;">Quantity</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($purchaseOrder->items as $item)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>
                                <div class="item-name">{{ $item->item_name }}</div>
                            </td>
                            <td style="text-align: right;">
                                {{ number_format($item->quantity) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">No items found in this purchase order.</td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align: right;">Total Quantity:</th>
                        <th style="text-align: right;">{{ number_format($purchaseOrder->total_quantity) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- NOTES --}}
        <div class="quotation-notes">
            Thank you for choosing <strong>Pro-Box Packages</strong>. We look forward to serving you.
        </div>

        {{-- BOTTOM ACTIONS --}}
        <div class="bottom-actions no-print">
            <a href="{{ route('purchase_orders.edit', $purchaseOrder) }}" class="btn-dark-custom">
                <i class="fas fa-edit"></i> Edit
            </a>

            <form action="{{ route('purchase_orders.destroy', $purchaseOrder) }}"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this Purchase Order?');"
                  style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger-custom">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>

            <a href="{{ route('purchase_orders.index') }}" class="btn-close-custom">
                Close
            </a>
        </div>

    </div>

</div>

@endsection