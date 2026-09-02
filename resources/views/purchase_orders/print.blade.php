<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Purchase Order - {{ $purchaseOrder->po_code ?? 'PO' }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: #f2f2f2;
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
        }

        /* =====================================================
           PRINT BUTTON
        ===================================================== */

        .print-toolbar {
            width: 210mm;
            margin: 20px auto;
            text-align: right;
        }

        .print-btn {
            background: #1f2937;
            color: #fff;
            border: 0;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        .print-btn:hover {
            background: #111827;
        }


        /* =====================================================
           A4 PAGE
        ===================================================== */

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto 20px;
            background: #fff;
            padding: 15mm;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .company-header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .company-header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .company-header .document-title {
            margin-top: 6px;
            font-size: 19px;
            font-weight: 700;
        }


        /* =====================================================
           PO HEADER BOX
        ===================================================== */

        .po-header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .po-header td {
            border: 1px solid #000;
            padding: 8px 10px;
            font-size: 13px;
            vertical-align: top;
        }

        .po-header .label {
            width: 17%;
            font-weight: 700;
            background: #f3f3f3;
        }

        .po-header .value {
            width: 33%;
        }


        /* =====================================================
           PARTY SECTION
        ===================================================== */

        .section-title {
            background: #eeeeee;
            border: 1px solid #000;
            padding: 8px 10px;
            font-weight: 700;
            font-size: 14px;
            margin-top: 10px;
        }

        .party-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .party-table td {
            border: 1px solid #000;
            padding: 9px 10px;
            vertical-align: top;
        }

        .party-label {
            width: 20%;
            font-weight: 700;
            background: #f7f7f7;
        }


        /* =====================================================
           ITEMS
        ===================================================== */

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .items-table th {
            border: 1px solid #000;
            background: #eeeeee;
            padding: 9px 8px;
            text-align: center;
            font-size: 13px;
        }

        .items-table td {
            border: 1px solid #000;
            padding: 9px 8px;
            font-size: 13px;
        }

        .items-table .serial {
            width: 12%;
            text-align: center;
        }

        .items-table .item-name {
            width: 58%;
        }

        .items-table .quantity {
            width: 30%;
            text-align: right;
        }

        .total-row td {
            font-weight: 700;
            background: #f3f3f3;
            padding: 10px 8px;
        }

        .total-label {
            text-align: right;
        }


        /* =====================================================
           ADDITIONAL DETAILS
        ===================================================== */

        .additional-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }

        .additional-table td {
            border: 1px solid #000;
            padding: 9px 10px;
        }

        .additional-table .label {
            width: 20%;
            font-weight: 700;
            background: #f7f7f7;
        }

        .additional-table .value {
            width: 30%;
        }


        /* =====================================================
           SIGNATURES
        ===================================================== */

        .signature-wrapper {
            width: 100%;
            margin-top: 80px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            width: 33.33%;
            text-align: center;
            padding: 0 15px;
            vertical-align: bottom;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 75%;
            margin: 0 auto 8px;
        }

        .signature-name {
            font-weight: 700;
            font-size: 13px;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            margin-top: 35px;
            text-align: center;
            font-size: 11px;
            color: #555;
        }


        /* =====================================================
           PRINT
        ===================================================== */

        @media print {

            html,
            body {
                background: #fff;
            }

            .print-toolbar {
                display: none;
            }

            .page {
                width: 100%;
                min-height: auto;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }

            @page {
                size: A4;
                margin: 12mm;
            }

            .section-title,
            .items-table th,
            .total-row td,
            .po-header .label,
            .party-label,
            .additional-table .label {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .items-table {
                page-break-inside: auto;
            }

            .items-table tr {
                page-break-inside: avoid;
            }

            .signature-wrapper {
                page-break-inside: avoid;
            }
        }

    </style>

</head>


<body>


{{-- =========================================================
     PRINT BUTTON
========================================================= --}}

<div class="print-toolbar">

    <button
        type="button"
        class="print-btn"
        onclick="window.print()">

        🖨 Print Purchase Order

    </button>

</div>


{{-- =========================================================
     A4 PAGE
========================================================= --}}

<div class="page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="company-header">

        <h1>
            PURCHASE ORDER
        </h1>

        <div class="document-title">

            {{ $purchaseOrder->po_code ?? 'N/A' }}

        </div>

    </div>


    {{-- =====================================================
         PO BASIC INFORMATION
    ====================================================== --}}

    <table class="po-header">

        <tr>

            <td class="label">
                PO Code
            </td>

            <td class="value">
                {{ $purchaseOrder->po_code ?? '-' }}
            </td>

            <td class="label">
                PO Date
            </td>

            <td class="value">

                @if($purchaseOrder->po_date)

                    {{ \Carbon\Carbon::parse($purchaseOrder->po_date)->format('d-m-Y') }}

                @else

                    -

                @endif

            </td>

        </tr>


        <tr>

            <td class="label">
                Delivery Date
            </td>

            <td class="value">

                @if($purchaseOrder->delivery_date)

                    {{ \Carbon\Carbon::parse($purchaseOrder->delivery_date)->format('d-m-Y') }}

                @else

                    -

                @endif

            </td>


            <td class="label">
                Machine Size
            </td>

            <td class="value">
                {{ $purchaseOrder->machine_size ?? '-' }}
            </td>

        </tr>

    </table>


    {{-- =====================================================
         PARTY DETAILS
    ====================================================== --}}

    <div class="section-title">
        PARTY DETAILS
    </div>


    <table class="party-table">

        <tr>

            <td class="party-label">
                Party Name
            </td>

            <td>
                {{ $purchaseOrder->party_name ?? '-' }}
            </td>

        </tr>


        <tr>

            <td class="party-label">
                Party Address
            </td>

            <td>

                @if(!empty($purchaseOrder->party_address))

                    {!! nl2br(e($purchaseOrder->party_address)) !!}

                @else

                    -

                @endif

            </td>

        </tr>

    </table>


    {{-- =====================================================
         ASSIGNMENT DETAILS
    ====================================================== --}}

    <div class="section-title">
        OTHER DETAILS
    </div>


    <table class="additional-table">

        <tr>

            <td class="label">
                Assign To
            </td>

            <td class="value">
                {{ $purchaseOrder->assign_to ?? '-' }}
            </td>

            <td class="label">
                Prepared By
            </td>

            <td class="value">

                @if($purchaseOrder->preparedBy)

                    {{ $purchaseOrder->preparedBy->name }}

                @else

                    -

                @endif

            </td>

        </tr>


        <tr>

            <td class="label">
                Print By
            </td>

            <td class="value">
                {{ $purchaseOrder->print_by ?? '-' }}
            </td>

            <td class="label">
                Machine Size
            </td>

            <td class="value">
                {{ $purchaseOrder->machine_size ?? '-' }}
            </td>

        </tr>

    </table>


    {{-- =====================================================
         ITEMS
    ====================================================== --}}

    <div class="section-title">
        ORDER ITEMS
    </div>


    <table class="items-table">

        <thead>

            <tr>

                <th class="serial">
                    #
                </th>

                <th class="item-name">
                    Item Name
                </th>

                <th class="quantity">
                    Quantity
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($purchaseOrder->items as $item)

                <tr>

                    <td class="serial">

                        {{ $loop->iteration }}

                    </td>

                    <td class="item-name">

                        {{ $item->item_name ?? '-' }}

                    </td>

                    <td class="quantity">

                        {{ number_format((int) $item->quantity) }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="3"
                        style="text-align:center; padding:20px;">

                        No items found.

                    </td>

                </tr>

            @endforelse

        </tbody>


        <tfoot>

            <tr class="total-row">

                <td
                    colspan="2"
                    class="total-label">

                    TOTAL QUANTITY

                </td>

                <td class="quantity">

                    {{ number_format((int) ($purchaseOrder->total_quantity ?? 0)) }}

                </td>

            </tr>

        </tfoot>

    </table>


    {{-- =====================================================
         SIGNATURES
    ====================================================== --}}

    <div class="signature-wrapper">

        <table class="signature-table">

            <tr>

                <td>

                    <div class="signature-line"></div>

                    <div class="signature-name">
                        Prepared By
                    </div>

                    <div>
                        {{ $purchaseOrder->preparedBy->name ?? '' }}
                    </div>

                </td>


                <td>

                    <div class="signature-line"></div>

                    <div class="signature-name">
                        Checked By
                    </div>

                </td>


                <td>

                    <div class="signature-line"></div>

                    <div class="signature-name">
                        Approved By
                    </div>

                </td>

            </tr>

        </table>

    </div>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="footer">

        Purchase Order — {{ $purchaseOrder->po_code ?? '' }}

    </div>


</div>


</body>

</html>