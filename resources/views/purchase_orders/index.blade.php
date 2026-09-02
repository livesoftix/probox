@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">

            <div class="page-title-box d-flex justify-content-between align-items-center">

                <h4 class="page-title">
                    Purchase Orders
                </h4>

                <a href="{{ route('purchase_orders.create') }}"
                   class="btn btn-primary">

                    <i class="mdi mdi-plus"></i>
                    Create Purchase Order

                </a>

            </div>

        </div>
    </div>


    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>PO Code</th>

                            <th>Party Name</th>

                            <th>PO Date</th>

                            <th>Delivery Date</th>

                            <th>Machine Size</th>

                            <th>Total Quantity</th>

                            <th>Prepared By</th>

                            <th width="180">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($purchaseOrders as $purchaseOrder)

                            <tr>

                                <td>
                                    {{ $loop->iteration + ($purchaseOrders->currentPage() - 1) * $purchaseOrders->perPage() }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $purchaseOrder->po_code }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $purchaseOrder->party_name }}
                                </td>

                                <td>
                                    {{ optional($purchaseOrder->po_date)->format('d-m-Y') }}
                                </td>

                                <td>
                                    {{ optional($purchaseOrder->delivery_date)->format('d-m-Y') ?? '-' }}
                                </td>

                                <td>
                                    {{ $purchaseOrder->machine_size }}
                                </td>

                                <td>
                                    {{ number_format($purchaseOrder->total_quantity) }}
                                </td>

                                <td>
                                    {{ $purchaseOrder->preparedBy->name ?? '-' }}
                                </td>

                                <td>

                                    <a href="{{ route('purchase_orders.show', $purchaseOrder) }}"
                                       class="btn btn-info btn-sm"
                                       title="View">

                                        <i class="mdi mdi-eye"></i>

                                    </a>


                                    <a href="{{ route('purchase_orders.edit', $purchaseOrder) }}"
                                       class="btn btn-warning btn-sm"
                                       title="Edit">

                                        <i class="mdi mdi-pencil"></i>

                                    </a>


                                    <a href="{{ route('purchase_orders.print', $purchaseOrder) }}"
                                       target="_blank"
                                       class="btn btn-secondary btn-sm"
                                       title="Print">

                                        <i class="mdi mdi-printer"></i>

                                    </a>


                                    <form action="{{ route('purchase_orders.destroy', $purchaseOrder) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this Purchase Order?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Delete">

                                            <i class="mdi mdi-delete"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9"
                                    class="text-center py-4">

                                    No Purchase Orders found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="mt-3">

                {{ $purchaseOrders->links() }}

            </div>

        </div>

    </div>

</div>

@endsection