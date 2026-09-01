<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Quotation - {{ $quotation->quotation_no }}</title>

    <style>

        @page {
            margin: 35px 40px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #000;
            margin: 0;
            padding: 0;
            font-size: 13px;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .quotation-header {
            width: 100%;
            border-bottom: 1px solid #d8d8d8;
            padding-bottom: 18px;
            margin-bottom: 18px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-left {
            width: 60%;
            vertical-align: middle;
        }

        .header-right {
            width: 40%;
            vertical-align: middle;
            text-align: right;
        }

        .company-section {
            width: 100%;
        }

        .logo {
            width: 60px;
            height: 50px;
            object-fit: contain;
            vertical-align: middle;
        }

        .company-info {
            display: inline-block;
            vertical-align: middle;
            margin-left: 12px;
        }

        .company-name {
            margin: 0;
            font-size: 23px;
            font-weight: bold;
            color: #000;
        }

        .company-name .box {
            color: #e9252b;
        }

        .premium-badge {
            margin-top: 5px;
            font-size: 9px;
            color: #526d89;
        }

        .quotation-heading {
            font-size: 28px;
            font-weight: bold;
            color: #000;
            letter-spacing: 1px;
        }

        /* =========================================================
           QUOTATION INFORMATION
        ========================================================= */

        .quotation-info {
            width: 100%;
            margin-bottom: 18px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 3px 0;
            font-size: 13px;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
        }

        /* =========================================================
           ITEMS TABLE
        ========================================================= */

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .items-table th {
            background: #d3d3d3;
            border: 1px solid #222;
            padding: 9px 12px;
            text-align: left;
            font-size: 13px;
            font-weight: bold;
        }

        .items-table td {
            border: 1px solid #222;
            padding: 8px 12px;
            font-size: 13px;
            vertical-align: middle;
        }

        .item-name {
            font-weight: bold;
        }

        .item-description {
            font-weight: normal;
        }

        /* =========================================================
           NOTES
        ========================================================= */

        .notes {
            margin-top: 28px;
            font-size: 13px;
            line-height: 1.6;
        }

        .notes strong {
            font-weight: bold;
        }

        /* =========================================================
           PRINT
        ========================================================= */

        @media print {

            body {
                margin: 0;
                padding: 0;
            }

            .quotation-header {
                border-bottom: 1px solid #d8d8d8;
            }

        }

    </style>
</head>

<body>

    {{-- =========================================================
         HEADER
    ========================================================= --}}

    <div class="quotation-header">

        <table class="header-table">

            <tr>

                {{-- LEFT: LOGO + COMPANY --}}
                <td class="header-left">

                    <div class="company-section">

                        {{-- 
                            For DomPDF:
                            use public_path() instead of asset()
                        --}}

                        <img
                            src="{{ public_path('assets/images/prologo.jpg') }}"
                            class="logo"
                            alt="Pro-Box Logo"
                        >

                        <div class="company-info">

                            <div class="company-name">
                                Pro-<span class="box">Box</span> Packages
                            </div>

                            <div class="premium-badge">
                                Printing &amp; Packaging Solution
                            </div>

                        </div>

                    </div>

                </td>


                {{-- RIGHT: QUOTATION --}}
                <td class="header-right">

                    <div class="quotation-heading">
                        QUOTATION
                    </div>

                </td>

            </tr>

        </table>

    </div>


    {{-- =========================================================
         QUOTATION INFORMATION
    ========================================================= --}}

    <div class="quotation-info">

        <table class="info-table">

            <tr>

                <td width="55%">
                    <span class="info-label">From:</span>
                    Pro-Box Packages
                </td>

                <td width="45%">
                    <span class="info-label">To:</span>
                    {{ $quotation->party_name ?? 'N/A' }}
                </td>

            </tr>

            <tr>

                <td>
                    <span class="info-label">Date:</span>

                    {{ \Carbon\Carbon::parse(
                        $quotation->quotation_date
                    )->format('d F Y') }}

                </td>

                <td>
                    <span class="info-label">Quotation No:</span>
                    {{ $quotation->quotation_no }}
                </td>

            </tr>

        </table>

    </div>


    {{-- =========================================================
         ITEMS
    ========================================================= --}}

    <table class="items-table">

        <thead>

            <tr>

                <th width="42%">
                    Item
                </th>

                <th width="58%">
                    Description
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($quotation->details as $item)

                <tr>

                    <td class="item-name">
                        {{ $item->item_name }}
                    </td>

                    <td class="item-description">
                        {{ $item->item_details ?? '-' }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="2" style="text-align:center;">
                        No quotation items found.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =========================================================
         NOTES
    ========================================================= --}}

    @if(!empty($quotation->description))

        <div class="notes">

            {!! nl2br(e($quotation->description)) !!}

        </div>

    @endif


</body>
</html>