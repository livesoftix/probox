@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Product Freezing List</h4>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="row">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('product-freezing.index') }}" method="GET">

                    <div class="row">

                        <div class="col-md-3">
                            <input type="date"
                                   name="date"
                                   value="{{ request('date') }}"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">

                            <select name="product_id"
                                    class="form-control select2">

                                <option value="">Select Product</option>

                                @foreach($products as $product)

                                <option value="{{ $product->id }}"
                                    {{ request('product_id')==$product->id ? 'selected':'' }}>

                                    {{ $product->prod_name }}

                                </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-3">

                            <button class="btn btn-primary">
                                Search
                            </button>

                            <a href="{{ route('product-freezing.index') }}"
                               class="btn btn-secondary">
                                Clear
                            </a>

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Success Message -->

    @if(session('success'))

    <div class="alert alert-success mt-2">
        {{ session('success') }}
    </div>

    @endif

    <!-- Listing -->

    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-body">

                    <a href="{{ route('product-freezing.create') }}"
                       class="btn btn-primary">

                        Add Product Freezing

                    </a>

                    <button class="btn btn-secondary"
                            onclick="printTable()">

                        Print Table

                    </button>

                    <br><br>

                    <table id="basic-datatable"
                           class="table table-bordered table-striped">

                        <thead>

                        <tr>

                            <th>Date</th>

                            <th>Slip No</th>

                            <th>Product</th>

                            <th>Status</th>

                            <th>Description</th>

                            <th class="no-print">
                                Action
                            </th>

                        </tr>

                        </thead>

                        <tbody>

                        @foreach($records as $row)

                        <tr>

                            <td>
                                {{ date('d-m-Y',strtotime($row->date)) }}
                            </td>

                            <td>
                                {{ $row->slip_no }}
                            </td>

                            <td>
                                {{ $row->product->prod_name }}
                            </td>

                            <td>

                                <span class="badge bg-danger">

                                    Inactive

                                </span>

                            </td>

                            <td>

                                {{ $row->description }}

                            </td>

                            <td class="no-print">

                                <a href="{{ route('product-freezing.show',$row->id) }}"
                                   class="btn btn-info btn-sm">

                                    View

                                </a>

                                <a href="{{ route('product-freezing.edit',$row->id) }}"
                                   class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <a href="{{ route('product-freezing.print',$row->id) }}"
                                   target="_blank"
                                   class="btn btn-success btn-sm">

                                    Print

                                </a>

                            </td>

                        </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function printTable(){

    $('.no-print').hide();

    var printContents=document.getElementById('basic-datatable').outerHTML;

    var original=document.body.innerHTML;

    document.body.innerHTML=printContents;

    window.print();

    document.body.innerHTML=original;

    location.reload();

}

</script>

@endsection