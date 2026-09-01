```blade
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>
        Quotation {{ $quotation->quotation_no }}
    </title>

    <style>

        @page {
            margin: 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #0f1e37;
            font-size: 13px;
            margin: 0;
        }

        .header {
            border-bottom: 2px solid #0f1e37;
            padding-bottom: 18px;
            margin-bottom: 22px;
        }

        .company-table {
            width: 100%;
            border-collapse: collapse;
        }

        .company-logo {
            width: 55px;
            height: 55px;
            background: #0f1e37;
            color: #dda42e;
            text-align: center;
            vertical-align: middle;
            font-size: 22px;
            font-weight: bold;
        }

        .company-name {
            font-size: 23px;
            font-weight: bold;
            padding-left: 12px;
        }

        .company-name .box {
            color: red;
        }

        .company-name .normal {
            color: #000000;
        }

        .quotation-heading {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
        }

        .quotation-number {
            color: #526d89;
            font-size: 11px;
            margin-top: 5px;
        }

        /* ================= INFORMATION ================= */

        .info-box {
            background: #f1f4f8;
            padding: 15px;
            margin-bottom: 22px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .info-table td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        .info-table td:first-child {
            padding-right: 20px;
        }

        .info-table td:last-child {
            padding-left: 20px;
        }

        .info-label {
            color: #526d89;
            font-size: 9px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 13px;
            font-weight: bold;
        }

        /* ================= ITEMS ================= */

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.items th {
            background: #0f1e37;
            color: white;
            padding: 10px 7px;
            font-size: 10px;
            text-align: left;
        }

        table.items td {
            padding: 10px 7px;
            border-bottom: 1px solid #dfe5ec;
            vertical-align: middle;
        }

        .text-right {
            text-align: right !important;
        }

        .item-name {
            font-weight: bold;
        }

        .details {
            color: #526d89;
        }

        .total-row td {
            border-top: 2px solid #0f1e37;
            border-bottom: none;
            padding-top: 15px;
        }

        .grand-total {
            color: #dda42e;
            font-size: 17px;
            font-weight: bold;
        }

        /* ================= DESCRIPTION ================= */

        .description-box {
            background: #f5f7f9;
            border-left: 4px solid #dda42e;
            padding: 14px 16px;
            margin-top: 25px;
        }

        .description-title {
            color: #526d89;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .description-content {
            line-height: 1.6;
        }

        /* ================= FOOTER ================= */

        .footer {
            margin-top: 35px;
            border-top: 1px solid #dfe5ec;
            padding-top: 12px;
            text-align: center;
            color: #8a98a9;
            font-size: 9px;
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

    </style>

</head>

<body>

@php
    $grandTotal = 0;
@endphp


{{-- ================= HEADER ================= --}}

<div class="header">

    <table class="company-table">

        <tr>

            <td width="60">

                 <div class="company-logo">
<img src="{{ public_path('assets/images/prologo.jpg') }}"
     width="60"
     height="55">            </div>

            </td>

            <td>

                <div class="company-name">
                    <span class="normal">Pro-</span><span class="box">Box</span><span class="normal"> Packages</span>
                </div>
                  <div class="premium-badge">
                    <i class="fas fa-box"></i>
                    Printing & Packaging Solution
                </div>

            </td>

            <td class="quotation-heading">

                QUOTATION

                <div class="quotation-number">
                    #{{ $quotation->quotation_no }}
                </div>

            </td>

        </tr>

    </table>

</div>


{{-- ================= INFORMATION ================= --}}

<div class="info-box">

    <table class="info-table">

        <tr>

            {{-- TO CLIENT --}}
            <td>

                <div class="info-label">
                    TO CLIENT
                </div>

                <div class="info-value">
                    {{ $quotation->party_name ?? 'N/A' }}
                </div>

            </td>


            {{-- DATE --}}
            <td>

                <div class="info-label">
                    DATE
                </div>

                <div class="info-value">
                    {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d M Y') }}
                </div>

            </td>

        </tr>

    </table>

</div>


{{-- ================= ITEMS ================= --}}

<table class="items">

    <thead>

        <tr>

            <th width="25%">
                Item
            </th>

            <th width="35%">
                Details
            </th>

            <th width="13%" class="text-right">
                Rate
            </th>

           

        </tr>

    </thead>

    <tbody>

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
                    <div class="details">
                        {{ $item->item_details ?? '-' }}
                    </div>
                </td>

                <td class="text-right">
                    PKR {{ number_format($rate, 2) }}
                </td>

            </tr>

        @empty

            <tr>

                <td colspan="5" style="text-align:center;">
                    No items found.
                </td>

            </tr>

        @endforelse


       

    </tbody>

</table>


{{-- ================= DESCRIPTION ================= --}}

@if(!empty($quotation->description))

    <div class="description-box">

        <div class="description-title">
            Description / Payment Terms
        </div>

        <div class="description-content">
            {!! nl2br(e($quotation->description)) !!}
        </div>

    </div>

@endif


{{-- ================= FOOTER ================= --}}

<div class="footer">

    Pro-Box Packages &nbsp; | &nbsp;
    Quotation {{ $quotation->quotation_no }}

</div>


</body>
</html>
