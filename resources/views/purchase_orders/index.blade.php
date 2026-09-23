@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Softix</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Purchase Orders</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Purchase Orders</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        @if (session('success'))
            <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('error') }}
            </div>
        @endif

        <!-- Purchase Orders Table -->
        <div class="row">
            <div class="card mt-2">
                <div class="card-body">
                    <style>
                        .action-toolbar {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            flex-wrap: wrap;
                            gap: 12px;
                            margin-bottom: 12px;
                        }

                        .action-toolbar .btn-group-custom {
                            display: flex;
                            align-items: center;
                            gap: 8px;
                            flex-wrap: wrap;
                        }

                        .action-toolbar .btn {
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            gap: 6px;
                            padding: 7px 18px;
                            font-size: 14px;
                            font-weight: 600;
                            border-radius: 6px;
                            white-space: nowrap;
                        }

                        .small-font-table {
                            font-size: 14px;
                            border: 1px solid #eef2f7;
                        }

                        .small-font-table th {
                            padding: 9px 12px;
                            vertical-align: middle;
                            font-weight: 700;
                            font-size: 14px;
                            border-bottom: 2px solid #d8e2ef;
                        }

                        .small-font-table td {
                            padding: 8px 12px;
                            vertical-align: middle;
                            font-size: 14px;
                            border-bottom: 1px solid #eef2f7;
                        }

                        .table-section {
                            margin-bottom: 20px;
                        }

                        .section-title {
                            font-weight: bold;
                            margin-bottom: 12px;
                            font-size: 18px;
                            color: #313a46;
                        }
                    </style>

                    <div class="action-toolbar no-print">
                        <div class="btn-group-custom">
                            <button type="button" class="btn btn-secondary" onclick="printTable()">
                                <i class="fas fa-print"></i>
                                <span>Print Table</span>
                            </button>
                            <a href="{{ route('purchase_orders.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                <span>Create New</span>
                            </a>
                        </div>
                        <div>
                            <span class="badge bg-primary px-2 py-1 fs-14">
                                Total Orders: {{ method_exists($purchaseOrders, 'total') ? $purchaseOrders->total() : $purchaseOrders->count() }}
                            </span>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="tab-content">
                                <div id="ledger">
                                    <div style="overflow-x: auto; width: 100%;">
                                        <div class="table-section">
                                            <div class="section-title">Purchase Orders</div>
                                            <table id="purchase-orders-table"
                                                class="table table-bordered table-hover dt-responsive nowrap w-100 small-font-table clean-table">
                                                <thead>
                                                    <tr>
                                                        <th class="table-primary text-center" style="width: 50px;">#</th>
                                                        <th class="table-primary text-center" style="white-space: nowrap; width: 120px;">PO Code</th>
                                                        <th class="table-primary text-center" style="white-space: nowrap; width: 100px;">PO Date</th>
                                                        <th class="table-primary" style="min-width: 170px;">Party Name</th>
                                                        <th class="table-primary" style="min-width: 200px;">Item Name</th>
                                                        <th class="table-primary text-center" style="white-space: nowrap; width: 100px;">Total Qty</th>
                                                        <th class="table-primary text-center" style="white-space: nowrap; width: 110px;">Delivery Date</th>
                                                        <th class="table-primary" style="white-space: nowrap; width: 120px;">Assign To</th>
                                                        <th class="table-primary" style="white-space: nowrap; width: 120px;">Prepared By</th>
                                                        <th class="table-primary text-center no-print" style="white-space: nowrap; width: 130px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($purchaseOrders as $key => $purchaseOrder)
                                                        <tr>
                                                            <td class="text-center fw-medium">
                                                                {{ method_exists($purchaseOrders, 'firstItem') ? ($purchaseOrders->firstItem() + $key) : ($key + 1) }}
                                                            </td>
                                                            <td class="text-center" style="white-space: nowrap; font-size: 14px;">
                                                                {{ $purchaseOrder->po_code ?? '-' }}
                                                            </td>
                                                            <td class="text-center" style="white-space: nowrap;">
                                                                {{ optional($purchaseOrder->po_date)->format('d-m-Y') ?? ($purchaseOrder->po_date ? date('d-m-Y', strtotime($purchaseOrder->po_date)) : '-') }}
                                                            </td>
                                                            <td>
                                                                <strong class="text-dark">{{ $purchaseOrder->party_name }}</strong>
                                                            </td>
                                                            <td>
                                                                @if($purchaseOrder->items && $purchaseOrder->items->count())
                                                                    @foreach($purchaseOrder->items as $item)
                                                                        <div>{{ $item->item_name }}</div>
                                                                    @endforeach
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center fw-bold" style="font-size: 14px;">
                                                                {{ number_format($purchaseOrder->total_quantity) }}
                                                            </td>
                                                            <td class="text-center" style="white-space: nowrap;">
                                                                {{ optional($purchaseOrder->delivery_date)->format('d-m-Y') ?? ($purchaseOrder->delivery_date ? date('d-m-Y', strtotime($purchaseOrder->delivery_date)) : '-') }}
                                                            </td>
                                                            <td>{{ $purchaseOrder->assign_to ?? '-' }}</td>
                                                            <td>{{ optional($purchaseOrder->preparedBy)->name ?? '-' }}</td>
                                                            <td class="no-print text-center" style="white-space: nowrap;">
                                                                <div class="d-inline-flex gap-1 align-items-center">
                                                                    <a href="{{ route('purchase_orders.show', $purchaseOrder) }}" class="btn btn-sm btn-info" title="View" style="padding: 4px 8px;">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('purchase_orders.edit', $purchaseOrder) }}" class="btn btn-sm btn-warning" title="Edit" style="padding: 4px 8px;">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <a href="{{ route('purchase_orders.print', $purchaseOrder) }}" target="_blank" class="btn btn-sm btn-secondary" title="Print" style="padding: 4px 8px;">
                                                                        <i class="fas fa-print"></i>
                                                                    </a>
                                                                    <form action="{{ route('purchase_orders.destroy', $purchaseOrder) }}" method="POST" class="d-inline delete-po-form" style="margin: 0;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" style="padding: 4px 8px;">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="10" class="text-center py-4 text-muted">
                                                                No Purchase Orders Found
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                                @if($purchaseOrders->count() > 0)
                                                    <tfoot>
                                                        <!-- Grand Total Row -->
                                                        <tr>
                                                            <td class="table-primary text-end pe-3" colspan="5">
                                                                <strong>G.Total:</strong>
                                                            </td>
                                                            <td class="table-primary text-center fw-bold" style="font-size: 14px;">
                                                                {{ number_format($purchaseOrders->sum('total_quantity')) }}
                                                            </td>
                                                            <td class="table-primary" colspan="4"></td>
                                                        </tr>
                                                    </tfoot>
                                                @endif
                                            </table>
                                        </div>

                                        @if(method_exists($purchaseOrders, 'hasPages') && $purchaseOrders->hasPages())
                                            <div class="mt-3 d-flex justify-content-end no-print">
                                                {{ $purchaseOrders->links() }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printTable() {
            const elementsToHide = document.querySelectorAll('.no-print');
            elementsToHide.forEach(el => el.style.display = 'none');
            const printContents = document.getElementById('ledger').outerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = `
                <html>
                    <head>
                        <title>Purchase Orders</title>
                        <style>
                            @page {
                                size: A4 landscape;
                                margin: 10mm;
                            }
                            body {
                                font-family: Arial, sans-serif;
                                font-size: 12px;
                                margin: 0;
                                padding: 15px;
                            }
                            .section-title {
                                font-size: 18px;
                                font-weight: bold;
                                margin-bottom: 15px;
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                            }
                            th, td {
                                border: 1px solid #ccc;
                                padding: 6px 8px;
                                text-align: left;
                                font-size: 12px;
                            }
                            th {
                                background-color: #f2f2f2;
                                font-weight: bold;
                            }
                            .text-center {
                                text-align: center;
                            }
                            .text-end {
                                text-align: right;
                            }
                            .no-print {
                                display: none !important;
                            }
                        </style>
                    </head>
                    <body>
                        ${printContents}
                    </body>
                </html>
            `;

            window.print();
            document.body.innerHTML = originalContents;
            window.location.reload();
        }

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