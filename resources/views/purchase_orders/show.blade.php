@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="page-title-box d-flex justify-content-between">

        <h4 class="page-title">
            Purchase Order {{ $purchaseOrder->po_code }}
        </h4>

        <div>

            <a href="{{ route('purchase_orders.edit', $purchaseOrder) }}"
               class="btn btn-warning">

                <i class="mdi mdi-pencil"></i>
                Edit

            </a>

            <a href="{{ route('purchase_orders.print', $purchaseOrder) }}"
               target="_blank"
               class="btn btn-secondary">

                <i class="mdi mdi-printer"></i>
                Print

            </a>

            <a href="{{ route('purchase_orders.index') }}"
               class="btn btn-light">

                Back

            </a>

        </div>

    </div>


    <div class="card">

        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-6">

                    <h5>
                        Party Information
                    </h5>

                    <p class="mb-1">
                        <strong>Party Name:</strong>
                        {{ $purchaseOrder->party_name }}
                    </p>

                    <p class="mb-1">
                        <strong>Address:</strong>
                        {{ $purchaseOrder->party_address ?? '-' }}
                    </p>

                </div>


                <div class="col-md-6">

                    <h5>
                        Purchase Order Information
                    </h5>

                    <p class="mb-1">
                        <strong>PO Code:</strong>
                        {{ $purchaseOrder->po_code }}
                    </p>

                    <p class="mb-1">
                        <strong>PO Date:</strong>
                        {{ $purchaseOrder->po_date->format('d-m-Y') }}
                    </p>

                    <p class="mb-1">
                        <strong>Delivery Date:</strong>
                        {{ $purchaseOrder->delivery_date
                            ? $purchaseOrder->delivery_date->format('d-m-Y')
                            : '-' }}
                    </p>

                    <p class="mb-1">
                        <strong>Machine Size:</strong>
                        {{ $purchaseOrder->machine_size }}
                    </p>

                </div>

            </div>


            <div class="row mb-4">

                <div class="col-md-4">

                    <strong>Assign To:</strong>
                    {{ $purchaseOrder->assign_to ?? '-' }}

                </div>

                <div class="col-md-4">

                    <strong>Prepared By:</strong>
                    {{ $purchaseOrder->preparedBy->name ?? '-' }}

                </div>

                <div class="col-md-4">

                    <strong>Print By:</strong>
                    {{ $purchaseOrder->print_by ?? '-' }}

                </div>

            </div>


            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th width="80">
                                #
                            </th>

                            <th>
                                Item Name
                            </th>

                            <th width="200">
                                Quantity
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($purchaseOrder->items as $item)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $item->item_name }}
                                </td>

                                <td>
                                    {{ number_format($item->quantity) }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                    <tfoot>

                        <tr>

                            <th colspan="2"
                                class="text-end">

                                Total Quantity

                            </th>

                            <th>

                                {{ number_format($purchaseOrder->total_quantity) }}

                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection