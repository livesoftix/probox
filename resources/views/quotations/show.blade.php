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
        font-size: 11px;
        color: #526d89;
        font-weight: 600;
    }

    .quotation-heading {
        text-align: right;
    }

    .quotation-heading h1 {
        margin: 0;
        font-size: 38px;
        font-weight: 800;
        color: #000;
        letter-spacing: .5px;
    }

    .quotation-number {
        margin-top: 5px;
        font-size: 13px;
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
       QUOTATION INFORMATION
    ========================================================= */

    .quotation-info {
        margin-top: 25px;
        margin-bottom: 20px;
    }

    .quotation-info-row {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
        font-size: 18px;
        color: #000;
    }

    .quotation-info-label {
        font-weight: 700;
        min-width: 55px;
    }

    .quotation-info-value {
        font-weight: 400;
    }


    /* =========================================================
       ITEMS TABLE
    ========================================================= */

    .quotation-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
    }

    .quotation-table th {
        background: #d3d3d3;
        color: #000;
        font-size: 17px;
        font-weight: 700;
        text-align: left;
        padding: 12px 16px;
        border: 1px solid #222;
    }

    .quotation-table td {
        color: #000;
        font-size: 17px;
        padding: 12px 16px;
        border: 1px solid #222;
        vertical-align: middle;
    }

    .quotation-table th:first-child {
        width: 43%;
    }

    .quotation-table th:last-child {
        width: 57%;
    }

    .item-name {
        font-weight: 700;
    }

    .item-details {
        font-weight: 400;
    }


    /* =========================================================
       NOTES
    ========================================================= */

    .quotation-notes {
        margin-top: 32px;
        font-size: 17px;
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


    /* =========================================================
       PRINT
    ========================================================= */

    @media print {

        body {
            background: #fff !important;
            margin: 0;
            padding: 0;
        }

        .quotation-wrapper {
            max-width: 100%;
            margin: 0;
        }

        .quotation-card {
            box-shadow: none;
            padding: 35px 40px;
        }

        .no-print {
            display: none !important;
        }

        .quotation-header {
            border-bottom: 1px solid #ddd !important;
        }

        .quotation-table th {
            background: #d3d3d3 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .quotation-table th,
        .quotation-table td {
            border: 1px solid #222 !important;
        }

        .quotation-notes {
            page-break-inside: avoid;
        }

    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

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

        .quotation-heading h1 {
            font-size: 30px;
        }

        .quotation-info-row {
            font-size: 16px;
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


        {{-- =========================================================
             HEADER
        ========================================================== --}}

        <div class="quotation-header">

            {{-- LEFT: LOGO + COMPANY --}}
            <div class="company-left">

                <img
                    src="{{ asset('assets/images/prologo.jpg') }}"
                    alt="Pro-Box Packages"
                    class="company-logo"
                >

                <div>

                    <h2 class="company-name">
                        Pro-<span>Box</span> Packages
                    </h2>

                    <div class="company-tagline">
                        Printing & Packaging Solution
                    </div>

                </div>

            </div>


            {{-- RIGHT: QUOTATION --}}
            <div class="quotation-heading">

                <h1>
                    QUOTATION
                </h1>

                @if(!empty($quotation->quotation_no))

                    <div class="quotation-number">
                        Quotation No:
                        <strong>{{ $quotation->quotation_no }}</strong>
                    </div>

                @endif

            </div>

        </div>


        {{-- =========================================================
             ACTION BUTTONS
        ========================================================== --}}

        <div class="top-actions no-print">

            <a
                href="{{ route('quotations.index') }}"
                class="btn-quotation"
            >
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

            <button
                type="button"
                class="btn-quotation"
                onclick="window.print()"
            >
                <i class="fas fa-print"></i>
                Print
            </button>

            <a
                href="{{ route('quotations.pdf', $quotation->id) }}"
                class="btn-quotation btn-gold"
            >
                <i class="fas fa-file-pdf"></i>
                PDF
            </a>

        </div>


        {{-- =========================================================
             QUOTATION INFO
        ========================================================== --}}

        <div class="quotation-info">

            {{-- FROM --}}
            <div class="quotation-info-row">

                <span class="quotation-info-label">
                    From:
                </span>

                <span class="quotation-info-value">
                    Pro-Box Packages
                </span>

            </div>


            {{-- TO --}}
            <div class="quotation-info-row">

                <span class="quotation-info-label">
                    To:
                </span>

                <span class="quotation-info-value">
                    {{ $quotation->party_name ?? 'N/A' }}
                </span>

            </div>


            {{-- DATE --}}
            <div class="quotation-info-row">

                <span class="quotation-info-label">
                    Date:
                </span>

                <span class="quotation-info-value">

                    {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d F Y') }}

                </span>

            </div>

        </div>


        {{-- =========================================================
             ITEMS
        ========================================================== --}}

        <div class="table-wrapper">

            <table class="quotation-table">

                <thead>

                    <tr>

                        <th>
                            Item
                        </th>

                        <th>
                            Description
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($quotation->details as $item)

                        <tr>

                            <td>

                                <div class="item-name">
                                    {{ $item->item_name }}
                                </div>

                            </td>

                            <td>

                                <div class="item-details">
                                    {{ $item->item_details ?: '-' }}
                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="2">

                                No quotation items found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =========================================================
             NOTES / DESCRIPTION
        ========================================================== --}}

        <div class="quotation-notes">

            @if(!empty($quotation->description))

                {!! nl2br(e($quotation->description)) !!}

            @else

                Thank you for choosing
                <strong>Pro-Box Packages</strong>.
                We look forward to serving you.

            @endif

        </div>


        {{-- =========================================================
             BOTTOM ACTIONS
        ========================================================== --}}

        <div class="bottom-actions no-print">

            <a
                href="{{ route('quotations.edit', $quotation->id) }}"
                class="btn-dark"
            >

                <i class="fas fa-edit"></i>

                Edit

            </a>


            <form
                action="{{ route('quotations.destroy', $quotation->id) }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete this quotation?');"
                style="display:inline;"
            >

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="btn-danger-custom"
                >

                    <i class="fas fa-trash"></i>

                    Delete

                </button>

            </form>


            <a
                href="{{ route('quotations.index') }}"
                class="btn-close-custom"
            >
                Close
            </a>

        </div>


    </div>

</div>

@endsection