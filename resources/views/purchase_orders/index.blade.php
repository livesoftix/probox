@extends('layouts.app')

@section('content')

<style>
    /* =========================================================
       PURCHASE ORDER INDEX
    ========================================================= */

    .po-index-page {
        min-height: calc(100vh - 70px);
        background: #f3f6fa;
        padding: 25px 26px 60px;
    }

    /* =========================================================
       TOP BRAND HEADER
    ========================================================= */

    .po-brand-header {
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

    .brand-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-print-btn {
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
        background: #ffffff;
        border: 1px solid #d8e1eb;
        color: #0d1b35;
        transition: all .2s ease;
    }

    .header-print-btn:hover {
        background: #f5f7fa;
        color: #0d1b35;
    }

    /* =========================================================
       PAGE TITLE
    ========================================================= */

    .po-title-area {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .po-title-left {
        display: flex;
        flex-direction: column;
    }

    .po-page-title {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 14px;
        color: #0d1b35;
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -0.6px;
    }

    .po-page-title i {
        color: #dba431;
        font-size: 31px;
    }

    .po-count {
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
       PO CARDS
    ========================================================= */

    .po-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 26px;
    }

    .po-card {
        background: #ffffff;
        border-radius: 19px;
        padding: 27px 29px 24px;
        box-shadow: 0 8px 25px rgba(20, 39, 65, .07);
        transition: all .2s ease;
        min-height: 255px;
        display: flex;
        flex-direction: column;
    }

    .po-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 13px 32px rgba(20, 39, 65, .11);
    }

    /* Card top */

    .po-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 25px;
    }

    .po-party-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
        max-width: 65%;
    }

    .po-party {
        margin: 0;
        color: #0d1b35;
        font-size: 20px;
        font-weight: 750;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .po-code-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 700;
        color: #0d1b35;
        background: #eef2f7;
        padding: 3px 10px;
        border-radius: 12px;
        width: fit-content;
    }

    .po-date {
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

    .po-date i {
        color: #526b86;
    }

    /* Items */

    .po-items {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        min-height: 34px;
        padding-bottom: 15px;
        border-bottom: 1px solid #dce3eb;
    }

    .po-item-chip {
        background: #f2f5f9;
        color: #0d1b35;
        border-radius: 18px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
    }

    .po-more-chip {
        background: #eef1f5;
        color: #65758a;
        border-radius: 18px;
        padding: 6px 12px;
        font-size: 12px;
    }

    /* Bottom information */

    .po-card-middle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 0 18px;
    }

    .po-meta-info {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #52657a;
        font-size: 14px;
    }

    .po-meta-info strong {
        color: #0d1b35;
        font-weight: 700;
    }

    /* Actions */

    .po-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: auto;
    }

    .po-view-btn,
    .po-edit-btn,
    .po-print-btn,
    .po-delete-btn {
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

    .po-view-btn {
        background: #0d1b35;
        color: #ffffff;
        padding: 0 17px;
    }

    .po-view-btn:hover {
        background: #172b4d;
        color: #ffffff;
    }

    .po-edit-btn,
    .po-print-btn {
        background: #ffffff;
        color: #0d1b35;
        border: 1px solid #d8e1eb;
        padding: 0 16px;
    }

    .po-edit-btn:hover,
    .po-print-btn:hover {
        background: #f4f7fa;
        color: #0d1b35;
    }

    .po-delete-btn {
        width: 46px;
        background: #e92d32;
        color: #ffffff;
        border: none;
        cursor: pointer;
    }

    .po-delete-btn:hover {
        background: #cf2227;
        color: #ffffff;
    }

    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .po-empty {
        background: #ffffff;
        border-radius: 20px;
        padding: 65px 30px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(20, 39, 65, .06);
    }

    .po-empty-icon {
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

    .po-empty h4 {
        color: #0d1b35;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .po-empty p {
        color: #708095;
        margin-bottom: 22px;
    }

    /* Responsive */

    @media (max-width: 900px) {
        .po-grid {
            grid-template-columns: 1fr;
        }

        .po-card {
            min-height: auto;
        }
    }

    @media (max-width: 650px) {
        .po-index-page {
            padding: 15px;
        }

        .po-brand-header {
            padding: 15px 18px;
        }

        .company-name {
            font-size: 20px;
        }

        .brand-actions {
            gap: 5px;
        }

        .header-print-btn {
            padding: 0 11px;
        }

        .po-title-area {
            align-items: flex-start;
        }

        .po-page-title {
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

        .po-card {
            padding: 22px;
        }

        .po-card-top {
            align-items: flex-start;
        }

        .po-party {
            font-size: 18px;
        }
    }
</style>

<div class="po-index-page">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius: 14px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- BRAND HEADER --}}
    <div class="po-brand-header">
        <div class="brand-left">
            <div>
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
            <button type="button" class="header-print-btn" onclick="window.print()">
                <i class="fas fa-print"></i>
                Print
            </button>
        </div>
    </div>

    {{-- PAGE TITLE --}}
    <div class="po-title-area">
        <div class="po-title-left">
            <h1 class="po-page-title">
                <i class="fas fa-file-alt"></i>
                Purchase Orders
            </h1>
            <div class="po-count">
                {{ method_exists($purchaseOrders, 'total') ? $purchaseOrders->total() : $purchaseOrders->count() }} total
            </div>
        </div>

        <a href="{{ route('purchase_orders.create') }}" class="create-new-btn">
            <i class="fas fa-plus"></i>
            Create New
        </a>
    </div>

    {{-- PURCHASE ORDERS GRID --}}
    @if($purchaseOrders->count())
        <div class="po-grid">
            @foreach($purchaseOrders as $purchaseOrder)
                <div class="po-card">
                    {{-- Card Header --}}
                    <div class="po-card-top">
                        <div class="po-party-info">
                            <h3 class="po-party" title="{{ $purchaseOrder->party_name }}">
                                {{ $purchaseOrder->party_name }}
                            </h3>
                            @if($purchaseOrder->po_code)
                                <span class="po-code-badge">
                                    <i class="fas fa-hashtag"></i> {{ $purchaseOrder->po_code }}
                                </span>
                            @endif
                        </div>

                        <div class="po-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ optional($purchaseOrder->po_date)->format('d M Y') ?? '-' }}
                        </div>
                    </div>

                    {{-- Items --}}
                    <div class="po-items">
                        @php
                            $items = $purchaseOrder->items ?? collect();
                        @endphp

                        @forelse($items->take(3) as $item)
                            <span class="po-item-chip">
                                {{ $item->item_name }}
                            </span>
                        @empty
                            <span class="po-item-chip">
                                No items
                            </span>
                        @endforelse

                        @if($items->count() > 3)
                            <span class="po-more-chip">
                                +{{ $items->count() - 3 }} more
                            </span>
                        @endif
                    </div>

                    {{-- Middle --}}
                    <div class="po-card-middle">
                        <div class="po-meta-info">
                            <span>
                                <strong>{{ $items->count() }}</strong> {{ $items->count() == 1 ? 'item' : 'items' }}
                            </span>
                            @if($purchaseOrder->total_quantity)
                                <span>•</span>
                                <span>
                                    Qty: <strong>{{ number_format($purchaseOrder->total_quantity) }}</strong>
                                </span>
                            @endif
                            @if($purchaseOrder->machine_size)
                                <span>•</span>
                                <span>Size: {{ $purchaseOrder->machine_size }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="po-actions">
                        {{-- View --}}
                        <a href="{{ route('purchase_orders.show', $purchaseOrder) }}" class="po-view-btn">
                            <i class="fas fa-eye"></i>
                            View
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('purchase_orders.edit', $purchaseOrder) }}" class="po-edit-btn">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>

                        {{-- Print --}}
                        <a href="{{ route('purchase_orders.print', $purchaseOrder) }}" target="_blank" class="po-print-btn" title="Print Purchase Order">
                            <i class="fas fa-print"></i>
                            Print
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('purchase_orders.destroy', $purchaseOrder) }}" method="POST" class="delete-po-form" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="po-delete-btn" title="Delete Purchase Order">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($purchaseOrders, 'hasPages') && $purchaseOrders->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $purchaseOrders->links() }}
            </div>
        @endif
    @else
        {{-- Empty --}}
        <div class="po-empty">
            <div class="po-empty-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <h4>No Purchase Orders Yet</h4>
            <p>Create your first purchase order.</p>
            <a href="{{ route('purchase_orders.create') }}" class="create-new-btn">
                <i class="fas fa-plus"></i>
                Create Purchase Order
            </a>
        </div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-po-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!confirm('Are you sure you want to delete this Purchase Order?')) {
                e.preventDefault();
            }
        });
    });
});
</script>

@endsection