@extends('layouts.app')
@section('content')
<div class="container pt-4">
    <h1>Dashboard</h1>
    <p>Confectionary report</p>

    <!-- CDC vouchers without CBILLs section -->
    <div class="card mt-4">
        <div class="card-header bg-warning text-dark">
            <h5>CDC Vouchers Without CBILL</h5>
        </div>
        <div class="card-body">
            @php
                // Get all CDC voucher numbers and details
                $cdcVouchers = \App\Models\ConfectioneryMaster::with('accounts')->get();
                $cbillVnos = \App\Models\ConfectBilling::pluck('old_vno')->toArray();
                $cdcWithoutCbill = $cdcVouchers->filter(function($voucher) use ($cbillVnos) {
                    return !in_array($voucher->v_no, $cbillVnos);
                });
            @endphp
            <p><strong>Total CDC vouchers without CBILL:</strong> {{ $cdcWithoutCbill->count() }}</p>
            @if($cdcWithoutCbill->count())
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Voucher No</th>
                            <th>Date</th>
                            <th>Account</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       @php
    $shownVnos = [];
@endphp

@foreach($cdcWithoutCbill as $voucher)
    @if(!in_array($voucher->v_no, $shownVnos))
        @php
            $shownVnos[] = $voucher->v_no;
        @endphp
        <tr>
            <td>{{ $voucher->v_no }}</td>
            <td>{{ $voucher->date ? \Carbon\Carbon::parse($voucher->date)->format('d-m-Y') : '' }}</td>
            <td>{{ $voucher->accounts->title ?? 'N/A' }}</td>
        </tr>
    @endif
@endforeach

                    </tbody>
                </table>
            </div>
            @else
                <p class="text-success">All PBILL vouchers have CBILLs.</p>
            @endif
             @php
                // Get all CDC voucher numbers and details
                $cdcVouchers = \App\Models\DeliveryMaster::with('accounts')->get();
                $cbillVnos = \App\Models\SaleInvoice::pluck('old_vno')->toArray();
                $cdcWithoutCbill = $cdcVouchers->filter(function($voucher) use ($cbillVnos) {
                    return !in_array($voucher->v_no, $cbillVnos);
                });
            @endphp
            <p><strong>Total Pharmaceutical vouchers without PBILL:</strong> {{ $cdcWithoutCbill->count() }}</p>
            @if($cdcWithoutCbill->count())
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Voucher No</th>
                            <th>Date</th>
                            <th>Account</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       @php
    $shownVnos = [];
@endphp

@foreach($cdcWithoutCbill as $voucher)
    @if(!in_array($voucher->v_no, $shownVnos))
        @php
            $shownVnos[] = $voucher->v_no;
        @endphp
        <tr>
            <td>{{ $voucher->v_no }}</td>
            <td>{{ $voucher->date ? \Carbon\Carbon::parse($voucher->date)->format('d-m-Y') : '' }}</td>
            <td>{{ $voucher->accounts->title ?? 'N/A' }}</td>
        </tr>
    @endif
@endforeach

                    </tbody>
                </table>
            </div>
            @else
                <p class="text-success">All CDC vouchers have CBILLs.</p>
            @endif
        </div>
        <!-- Assigned Products Section -->
<div class="card mt-4">
    <div class="card-header bg-primary text-white">
    <h5>
    Assigned Products - {{ auth()->user()->name ?? 'User' }}
</h5>
    </div>

    <div class="card-body">
        @if($assignedProducts->count())

            <p><strong>Total Assigned:</strong> {{ $assignedProducts->count() }}</p>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>SR</th>
                            <th>Actions</th>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Party</th>
                            <th>Country</th>
                            <th>Item</th>
                            <th>Grammage</th>
                            <th>Size</th>
                            <!-- <th>Rate</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignedProducts as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <!-- ACTION BUTTONS -->
                                <td>
                                    <div class="d-flex gap-1">

                                        <!-- VIEW -->
                                        <a href="{{ route('registration_form.show', $product->id) }}"
                                           class="btn btn-outline-info btn-sm"
                                           title="View">
                                            <i class="uil uil-eye"></i>
                                        </a>

                                        <!-- EDIT -->
                                        <a href="{{ route('registration_form.edit', $product->id) }}"
                                           onclick="return checkPermissionEdit()"
                                           class="btn btn-outline-primary btn-sm"
                                           title="Edit">
                                            <i class="uil uil-edit"></i>
                                        </a>

                                        <!-- DELETE -->
                                        <form action="{{ route('registration_form.destroy', $product->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this product?')"
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    onclick="return checkPermissionDel()"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Delete">
                                                <i class="uil uil-trash-alt"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                                <td>
                                    {{ $product->created_at ? \Carbon\Carbon::parse($product->created_at)->format('d-m-Y') : '' }}
                                </td>
                                <td>{{ $product->prod_name }}</td>
                                <td>{{ $product->product_type }}</td>
                                <td>{{ $product->account->title ?? 'N/A' }}</td>
                                <td>{{ $product->country->country_name ?? 'N/A' }}</td>
                                <td>{{ $product->items->item_code ?? 'N/A' }}</td>
                                <td>{{ $product->grammage }}</td>
                                <td>{{ $product->length }} × {{ $product->width }}</td>
                                <!-- <td>{{ $product->rate }}</td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <p class="text-success">No assigned products</p>
        @endif
    </div>
</div>
    </div>


@endsection
