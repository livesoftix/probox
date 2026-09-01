@extends('layouts.app')

@section('content')

<style>
    /* =========================================================
       QUOTATION INDEX
    ========================================================= */

    .quotation-index-page {
        min-height: calc(100vh - 70px);
        background: #f3f6fa;
        padding: 25px 26px 60px;
    }

    /* =========================================================
       TOP BRAND HEADER
    ========================================================= */

    .quotation-brand-header {
        background: #ffffff;
        border-radius: 20px;
        min-height: 88px;
        padding: 16px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 8px 28px rgba(20, 39, 65, 0.08);
        margin-bottom: 38px;
    }

    .brand-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .brand-logo {
        width: 54px;
        height: 54px;
        background: #0d1b35;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dda632;
        font-size: 25px;
        font-weight: 800;
        box-shadow: 0 5px 12px rgba(13, 27, 53, .18);
    }

    .brand-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .brand-name {
        margin: 0;
        font-size: 25px;
        line-height: 1;
        font-weight: 800;
        color: #0d1b35;
        letter-spacing: -0.5px;
    }

    .brand-name .gold {
        color: #dba431;
    }

    .premium-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        width: fit-content;
        margin-top: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        background: #f1f4f8;
        color: #596a80;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .4px;
    }

    .premium-badge i {
        font-size: 10px;
    }

    /* Header Buttons */

    .brand-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-print-btn,
    .header-new-btn {
        height: 36px;
        padding: 0 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all .2s ease;
    }

    .header-print-btn {
        background: #ffffff;
        border: 1px solid #d8e1eb;
        color: #0d1b35;
    }

    .header-print-btn:hover {
        background: #f5f7fa;
        color: #0d1b35;
    }

    .header-new-btn {
        background: #0d1b35;
        color: #ffffff;
        border: 1px solid #0d1b35;
    }

    .header-new-btn:hover {
        background: #172b4d;
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* =========================================================
       PAGE TITLE
    ========================================================= */

    .quotation-title-area {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .quotation-title-left {
        display: flex;
        flex-direction: column;
    }

    .quotation-page-title {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 14px;
        color: #0d1b35;
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -0.6px;
    }

    .quotation-page-title i {
        color: #dba431;
        font-size: 31px;
    }

    .quotation-count {
        margin-top: 9px;
        color: #53677e;
        font-size: 16px;
    }

    .create-new-btn {
        height: 45px;
        padding: 0 25px;
        background: #dda632;
        color: #ffffff;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        font-size: 16px;
        font-weight: 700;
        box-shadow: 0 5px 12px rgba(221, 166, 50, .18);
        transition: all .2s ease;
    }

    .create-new-btn:hover {
        background: #c99427;
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* =========================================================
       QUOTATION CARDS
    ========================================================= */

    .quotation-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 26px;
    }

    .quotation-card {
        background: #ffffff;
        border-radius: 19px;
        padding: 27px 29px 24px;
        box-shadow: 0 8px 25px rgba(20, 39, 65, .07);
        transition: all .2s ease;
        min-height: 255px;
        display: flex;
        flex-direction: column;
    }

    .quotation-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 13px 32px rgba(20, 39, 65, .11);
    }

    /* Card top */

    .quotation-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 25px;
    }

    .quotation-party {
        margin: 0;
        color: #0d1b35;
        font-size: 20px;
        font-weight: 750;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 65%;
    }

    .quotation-date {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f2f5f9;
        color: #52657a;
        padding: 7px 13px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .quotation-date i {
        color: #526b86;
    }

    /* Items */

    .quotation-items {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        min-height: 34px;
        padding-bottom: 15px;
        border-bottom: 1px solid #dce3eb;
    }

    .quotation-item-chip {
        background: #f2f5f9;
        color: #0d1b35;
        border-radius: 18px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
    }

    .quotation-more-chip {
        background: #eef1f5;
        color: #65758a;
        border-radius: 18px;
        padding: 6px 12px;
        font-size: 12px;
    }

    /* Bottom information */

    .quotation-card-middle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 0 18px;
    }

    .quotation-total {
        color: #5c6e84;
        font-size: 15px;
    }

    .quotation-total strong {
        color: #dba431;
        font-size: 22px;
        font-weight: 800;
        margin-left: 4px;
    }

    .quotation-item-count {
        color: #52657a;
        font-size: 14px;
    }

    /* Actions */

    .quotation-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: auto;
    }

    .quotation-view-btn,
    .quotation-edit-btn,
    .quotation-delete-btn {
        height: 36px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all .2s ease;
    }

    .quotation-view-btn {
        background: #0d1b35;
        color: #ffffff;
        padding: 0 17px;
    }

    .quotation-view-btn:hover {
        background: #172b4d;
        color: #ffffff;
    }

    .quotation-edit-btn {
        background: #ffffff;
        color: #0d1b35;
        border: 1px solid #d8e1eb;
        padding: 0 16px;
    }

    .quotation-edit-btn:hover {
        background: #f4f7fa;
        color: #0d1b35;
    }

    .quotation-delete-btn {
        width: 46px;
        background: #e92d32;
        color: #ffffff;
        border: none;
        cursor: pointer;
    }

    .quotation-delete-btn:hover {
        background: #cf2227;
        color: #ffffff;
    }
            .company-name {
    margin: 0;
    font-size: 26px;
    font-weight: 800;
    color: #000;
    line-height: 1.1;
}

  .company-name span {
    color: #e9252b;
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

    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .quotation-empty {
        background: #ffffff;
        border-radius: 20px;
        padding: 65px 30px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(20, 39, 65, .06);
    }

    .quotation-empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 18px;
        background: #f3f6fa;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dba431;
        font-size: 29px;
    }

    .quotation-empty h4 {
        color: #0d1b35;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .quotation-empty p {
        color: #708095;
        margin-bottom: 22px;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 900px) {

        .quotation-grid {
            grid-template-columns: 1fr;
        }

        .quotation-card {
            min-height: auto;
        }
    }

    @media (max-width: 650px) {

        .quotation-index-page {
            padding: 15px;
        }

        .quotation-brand-header {
            padding: 15px 18px;
        }

        .brand-name {
            font-size: 20px;
        }

        .brand-actions {
            gap: 5px;
        }

        .header-print-btn,
        .header-new-btn {
            padding: 0 11px;
        }

        .header-new-btn {
            font-size: 0;
        }

        .header-new-btn i {
            font-size: 15px;
            margin-right: 0 !important;
        }

        .quotation-title-area {
            align-items: flex-start;
        }

        .quotation-page-title {
            font-size: 25px;
        }

        .create-new-btn {
            font-size: 0;
            width: 45px;
            padding: 0;
        }

        .create-new-btn i {
            font-size: 16px;
            margin: 0 !important;
        }

        .quotation-card {
            padding: 22px;
        }

        .quotation-card-top {
            align-items: flex-start;
        }

        .quotation-party {
            font-size: 18px;
        }
    }
</style>


<div class="quotation-index-page">

    {{-- ========================================================= --}}
    {{-- BRAND HEADER --}}
    {{-- ========================================================= --}}

    <div class="quotation-brand-header">

        <div class="brand-left">

              <div >
               <img src="{{ asset('assets/images/prologo.jpg') }}" alt="Logo" height="50" width="60" class="bg-white" />
            </div>

            <div class="brand-info">

                <h2 class="company-name"> Pro-<span>Box</span> Packages </h2>

                <div class="premium-badge">
                    <i class="fas fa-box"></i>
                    Printing & Packaging Solution
                </div>

            </div>

        </div>


        <div class="brand-actions">

            {{-- Print --}}
            <button
                type="button"
                class="header-print-btn"
                onclick="window.print()"
            >

                <i class="fas fa-print"></i>

                Print

            </button>


            {{-- New Quotation --}}
            <a
                href="{{ route('quotations.create') }}"
                class="header-new-btn"
            >

                <i class="fas fa-plus"></i>

                New Quotation

            </a>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PAGE TITLE --}}
    {{-- ========================================================= --}}

    <div class="quotation-title-area">

        <div class="quotation-title-left">

            <h1 class="quotation-page-title">

                <i class="fas fa-file-invoice"></i>

                Quotations

            </h1>

            <div class="quotation-count">

                {{ $quotations->count() }} total

            </div>

        </div>


        <a
            href="{{ route('quotations.create') }}"
            class="create-new-btn"
        >

            <i class="fas fa-plus"></i>

            Create New

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- QUOTATIONS --}}
    {{-- ========================================================= --}}

    @if($quotations->count())

        <div class="quotation-grid">

            @foreach($quotations as $quotation)
       

                <div class="quotation-card">

                    {{-- Card Header --}}
                    <div class="quotation-card-top">

                        <h3 class="quotation-party">

                            {{ $quotation->party_name }}

                        </h3>


                        <div class="quotation-date">

                            <i class="far fa-calendar-alt"></i>

                            {{ \Carbon\Carbon::parse($quotation->date)->format('d M Y') }}

                        </div>

                    </div>


                    {{-- Items --}}
                    <div class="quotation-items">

                        @php
                            $items = $quotation->details ?? collect();
                            $grand_total = 0;
                        @endphp

                        @forelse($items->take(3) as $item)
                         @php
                              $grand_total = $grand_total + $item->amount;

                            @endphp

                            <span class="quotation-item-chip">

                                {{ $item->item_name }}

                            </span>

                        @empty

                            <span class="quotation-item-chip">

                                No items

                            </span>
                           

                        @endforelse


                        @if($items->count() > 3)

                            <span class="quotation-more-chip">

                                +{{ $items->count() - 3 }} more

                            </span>

                        @endif

                    </div>


                    {{-- Total --}}
                    <div class="quotation-card-middle">

                        <div class="quotation-total">

                            Total 

                            <strong>
                                PKR {{ number_format($grand_total ?? $grand_total ?? 0, 0) }}
                            </strong>

                        </div>


                        <div class="quotation-item-count">

                            {{ $items->count() }}

                            {{ $items->count() == 1 ? 'item' : 'items' }}

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="quotation-actions">

                        {{-- View --}}
                        <a
                            href="{{ route('quotation.show', $quotation->id) }}"
                            class="quotation-view-btn"
                        >

                            <i class="fas fa-eye"></i>

                            View

                        </a>


                        {{-- Edit --}}
                        <a
                            href="{{ route('quotations.edit', $quotation->id) }}"
                            class="quotation-edit-btn"
                        >

                            <i class="fas fa-edit"></i>

                            Edit

                        </a>


                        {{-- Delete --}}
                        <form
                            action="{{ route('quotations.destroy', $quotation->id) }}"
                            method="POST"
                            class="delete-quotation-form"
                            style="margin: 0;"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="quotation-delete-btn"
                                title="Delete Quotation"
                            >

                                <i class="fas fa-trash"></i>

                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        {{-- Empty --}}
        <div class="quotation-empty">

            <div class="quotation-empty-icon">

                <i class="fas fa-file-invoice"></i>

            </div>

            <h4>No Quotations Yet</h4>

            <p>
                Create your first quotation for a client.
            </p>

            <a
                href="{{ route('quotations.create') }}"
                class="create-new-btn"
            >

                <i class="fas fa-plus"></i>

                Create Quotation

            </a>

        </div>

    @endif

</div>


{{-- ========================================================= --}}
{{-- DELETE CONFIRMATION --}}
{{-- ========================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-quotation-form')
        .forEach(function (form) {

            form.addEventListener('submit', function (e) {

                if (!confirm('Are you sure you want to delete this quotation?')) {

                    e.preventDefault();

                }

            });

        });

});
</script>

@endsection